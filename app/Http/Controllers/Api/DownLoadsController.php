<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Exports\ClientExport;
use App\Exports\PaymentsExport;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Exports\ApplicationsExport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\ClientRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\Response;
use App\Repositories\ApplicationRepository;
use Illuminate\Database\Eloquent\Collection;


class DownLoadsController extends Controller
{
    private ApplicationRepository $applicationRepository;
    private PaymentRepository $paymentRepository;

    private ClientRepository $clientRepository;

    public function __construct(
        ApplicationRepository $applicationRepository,
        PaymentRepository $paymentRepository,
        ClientRepository $clientRepository
    ){

        $this->applicationRepository = $applicationRepository;
        $this->paymentRepository = $paymentRepository;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Display a paginated list of applications.
     * @throws \Exception
     */
    public function downloadApplicationsExcel(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse|JsonResponse
    {
        $applications = $this->applicationRepository
            ->with(['client', 'career', 'status', 'payments'])
            ->when($request->has('name') && !empty($request->get('name')), function ($query) use ($request) {
                $search = $request->get('name');
                $query->whereHas('client', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                        ->orWhere('surname', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('phone_number', 'like', "%$search%");
                });
            })
            ->when($request->has('passport_or_id') && !empty($request->get('passport_or_id')), function ($query) use ($request) {
                $passportId = $request->get('passport_or_id');
                $query->whereHas('client', function ($q) use ($passportId) {
                    $q->where('passport_number', 'like', "%$passportId%")
                        ->orWhere('id_number', 'like', "%$passportId%");
                });
            })
            ->when($request->has('from') && !empty($request->get('from')) && $request->has('to') && !empty($request->get('to')), function ($query) use ($request) {
                $query->whereBetween('created_at',[$request->get('from'), $request->get('to')]);
            })
            ->when($request->has('status_id') && !empty($request->get('status_id')), function ($query) use ($request) {
                $query->where('status_id', $request->get('status_id'));
            })
            ->get();

        $timestamp = time();
        $title = 'Applications Report';

        $aggregated_applications = $applications->groupBy(function ($application) {
            return $application->created_at->format('jS M Y');
        })
            ->mapWithKeys(function ($group, $data) {
                $rows = [];
                foreach ($group as $record) {
                    $rows[] = [
                        'client_name' => $record->client->surname .' '. $record->client->first_name,
                        'client_email' => $record->client->email,
                        'client_phone_number' => $record->client->phone_number,
                        'client_passport_number' => $record->client->passport_number ?? null,
                        'client_id_number' => $record->client->id_number ?? null,
                        'career' => $record->career->name ?? null,
                        'application_code' => $record->application_code ?? null,
                        'status' => $record->status->name ?? null,
                    ];
                }
                return [
                    $data => [
                        'items' => $rows,
                    ],
                ];
            });

        $aggregated_array = $aggregated_applications->toArray();

        $eloquentCollection = collect($aggregated_array)->map(function ($item) {
            return (object) $item;
        });

        $eloquentCollection = new Collection($eloquentCollection);

        return Excel::download(new ApplicationsExport($eloquentCollection, $title), 'applications_report_' . $timestamp . '.xlsx');
    }

    public function downloadPaymentsExcel(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse|JsonResponse
    {

        $payments = $this->paymentRepository
            ->with(['status', 'client', 'applicationPayment'])
            ->when($request->filled('name'), function ($query) use ($request) {
                $search = $request->get('name');
                $query->whereHas('client', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                        ->orWhere('surname', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            })
            ->when($request->filled('status_id'), function ($query) use ($request) {
                $query->where('status_id', $request->get('status_id'));
            })
            ->when($request->filled('from'), function ($query) use ($request) {
                $from = $request->get('from');
                $to = $request->get('to');
                $query->whereBetween('created_at', [$from, $to]);
            })

            ->when($request->filled('min_amount') || $request->filled('max_amount'), function($query) use($request) {
                $min = floatval($request->get('min_amount'));
                $max = floatval($request->get('max_amount'));

                if ($request->filled('min_amount') && $request->filled('max_amount')) {
                    $query->whereRaw('CAST(amount AS DECIMAL(10,2)) BETWEEN ? AND ?', [$min, $max]);
                } elseif ($request->filled('min_amount')) {
                    $query->whereRaw('CAST(amount AS DECIMAL(10,2)) >= ?', [$min]);
                } elseif ($request->filled('max_amount')) {
                    $query->whereRaw('CAST(amount AS DECIMAL(10,2)) <= ?', [$max]);
                }
            })
            ->get();

        $timestamp = time();
        $title = 'Payments Report';

        $aggregated_payments = $payments->groupBy(function ($payment) {
            return $payment->created_at->format('jS M Y');
        })
            ->mapWithKeys(function ($group, $data) {
                $totalAmount = 0;

                $rows = [];
                foreach ($group as $record) {

                    $rows[] = [
                        'client_name' => $record->client->surname .' '. $record->client->first_name,
                        'client_email' => $record->client->email,
                        'client_phone_number' => $record->client->phone_number,
                        'amount' => $record->amount,
                        'transaction_reference' => $record->transaction_reference ?? null,
                        'application_code' => $record->applicationPayment->application->application_code ?? null,
                        'job_applied' => $record->applicationPayment->application->career->name ?? null,
                        'status' => $record->status->name ?? null,
                    ];

                    $totalAmount +=  $record->amount;
                }
                return [
                    $data => [
                        'amount' => number_format($totalAmount, 2),
                        'items' => $rows,
                    ],
                ];
            });

        $aggregated_array = $aggregated_payments->toArray();

        $eloquentCollection = collect($aggregated_array)->map(function ($item) {
            return (object) $item;
        });
        $eloquentCollection = new Collection($eloquentCollection);

        return Excel::download(new PaymentsExport($eloquentCollection, $title), 'payments_report_' . $timestamp . '.xlsx');


    }


    public function downloadClientsExcel(Request $request) {
         $clients = $this->clientRepository
            ->when($request->has('name') && !empty($request->get('name')), function ($query) use ($request) {
                $query->where('first_name', 'like', "%{$request->name}%")
                    ->orWhere('surname', 'like', "%{$request->name}%")
                    ->orWhere('email', 'like', "%{$request->name}%")
                    ->orWhere('phone_number', 'like', "%{$request->name}%");
            })
            ->when($request->has('passport_or_id') && !empty($request->get('passport_or_id')), function ($query) use ($request) {
                $query->where('passport_number', 'like', "%{$request->passport_or_id}%")
                    ->orWhere('id_number', 'like', "%{$request->passport_or_id}%");
            })
            ->when($request->has('from') && !empty($request->get('from')) && $request->has('to') && !empty($request->get('to')), function ($query) use ($request) {
            $query->whereBetween('created_at',[$request->get('from'), $request->get('to')]);
        })
        ->get();


       $timestamp = time();
       $title = 'Clients Report';

       $aggregated_clients = $clients ->groupBy(function($clients)
       {
        return $clients->created_at->format('jS M Y');
       })

            ->mapWithKeys(function($group, $data)
            {
                $rows = [];
                foreach($group as $record) {
                    Log::info($record);
                    $rows[] = [
                        'client_name' => $record->surname .' '. $record->first_name,
                        'client_email' => $record->email,
                        'client_phone_number' => $record->phone_number,
                        'client_passport_number' => $record->passport_number,
                        'client_id_number' => $record->id_number,
                    ];

                }  
                   
                return [
                    $data => [
                        'items' => $rows,
                    ],
                ];
            });
        
        $aggregated_array = $aggregated_clients->toArray();
        
        $eloquentCollection = collect($aggregated_array)->map(function ($item) {
            return (object) $item;
        });



        $eloquentCollection = new Collection($eloquentCollection);

        return Excel::download(new ClientExport($eloquentCollection,$title), 'clients_report_' . $timestamp . '.xlsx');
    }


public function downloadPaymentPdf($applicationPaymentId)
{
    // Get the pivot record with all relationships
    $applicationPayment = DB::table('application_payments')
        ->where('id', $applicationPaymentId)
        ->first();

    if (!$applicationPayment) {
        abort(404, 'Payment record not found');
    }

    // Load all related data
    $application = Application::with(['client', 'career', 'status'])
        ->find($applicationPayment->application_id);

    $payment = Payment::find($applicationPayment->payment_id);

    $data = [
        'application' => $application,
        'payment' => $payment,
        'client' => $application->client,
        'career' => $application->career,
        'status' => $application->status,
        'amount' => $applicationPayment->amount,
        'balance' => $applicationPayment->balance,
        'application_payment' => $applicationPayment
    ];

    $pdf = Pdf::loadView('components.receipts.payment_receipt', $data);
    
    return $pdf->download('receipt_'.$application->application_code.'.pdf');
}

}
