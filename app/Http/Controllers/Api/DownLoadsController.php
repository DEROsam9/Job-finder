<?php

namespace App\Http\Controllers\Api;

use App\Exports\ApplicationsExport;
use App\Http\Controllers\Controller;
use App\Repositories\ApplicationRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DownLoadsController extends Controller
{
    private ApplicationRepository $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository){
        $this->applicationRepository = $applicationRepository;
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
}
