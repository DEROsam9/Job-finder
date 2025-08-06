<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Repositories\ClientRepository;
use DB;
use App\Models\Client;
use App\Models\Payment;
use App\Http\Traits\mpesa;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\ClientDocument;
use App\Models\ApplicationPayment;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Support\Facades\Validator;


class ClientController extends Controller
{
    use mpesa;
    /**
     * Display a listing of the resource.
     */

    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepo)
    {
        $this->clientRepository = $clientRepo;
    }

    public function index(Request $request)
    {
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
            ->paginate($request->get('limit', 20));

        return response()->json([
            'data' => $clients->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'       => 'required|string|max:255',
            'surname'          => 'required|string|max:255',
            'email'            => 'required|email',
            'phone_number'     => 'required|string|max:20',
            'passport_number'  => 'nullable|string|max:50',
            'passport_expiry_date' => 'nullable|date|after:today',
            'id_number'        => 'required|string|max:50',

        // Files
        'cv'               => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        'passport_copy'    => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        'passport_photo'   => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        'client_id_front'  => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        'client_id_back'   => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        'good_conduct'     => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',

            // Job selection
            'job_title'    => 'required|array',
            'job_title.*'  => 'exists:careers,id',
            'job_category' => 'nullable|array',
            'job_category.*' => 'exists:job_categories,id',

            // Optional additional fields
            'remarks'          => 'nullable|string|max:255',
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        \Log::info('Client creation request validated', $request->all());

        try {
            DB::beginTransaction();
            $input = $request->all();

            $client = $this->clientRepository->where('email',$input['email'] )
                ->orWhere('phone_number', $input['phone_number'])
                ->first();

            if (!$client) {
                $client = $this->clientRepository->create([
                    'surname' => $input['surname'],
                    'first_name' => $input['first_name'],
                    'email' => $input['email'],
                    'phone_number' => $input['phone_number'],
                    'passport_number' => $input['passport_number'],
                    // 'passport_number' => $input['passport_number'] ?? '',
                    'id_number' => $input['id_number'],
                ]);

                $docFields = [
                    'cv'              => null,
                    'passport_copy'   => null,
                    'passport_photo'   => null,
                    'client_id_front' => null,
                    'client_id_back'  => null,
                    'good_conduct'=> null,
                ];

                foreach ($docFields as $field => $expiryField) {
                    $uploadedFile = $request->file($field);

                    if (!$uploadedFile || !$uploadedFile->isValid()) {
                        continue;
                    }

                    $document_url = uploadToOBS($uploadedFile);
                    $passport_expiry_date = $expiryField ? $request->input($expiryField) : null;

                    ClientDocument::create([
                        'client_id'            => $client->id,
                        'remarks'              => $request->input('remarks'),
                        'document_type'        => $field,
                        'passport_expiry_date' => $passport_expiry_date,
                        'document_url'         => $document_url,
                    ]);
                }
            }

            foreach ($request->job_title as $jobId) {
                $application = Application::create([
                    'client_id' => $client->id,
                    'career_id' => $jobId,
                    'status_id' => Status::where('code','DRAFT')->first()->id,
                    'remarks'   => $request->get('experience_brief'),
                ]);
            }

            $data = [
                'application_code' => $application->application_code,
                'phone_number'     => $client->phone_number,
                'amount'           => 1000
            ];

            $response = $this->stkPushRequest($data);

            if (isset($response["ResponseCode"]) && $response["ResponseCode"] == "0") {
                $payment = Payment::create([
                    'client_id'            => $client->id,
                    'amount'               => 1000,
                    'status_id'            => loadStatusId('Draft'),
                    'transaction_reference'=> '',
                    'remarks'              => 'payment for application coded '.$application->application_code,
                    'merchant_request_id'  => $response['MerchantRequestID'],
                    'checkout_request_id'  => $response['CheckoutRequestID']
                ]);

                ApplicationPayment::create([
                    'client_id'     => $client->id,
                    'payment_id'    => $payment->id,
                    'application_id'=> $application->id,
                    'amount'        => 0,
                    'balance'       => 1000
                ]);
            } else {
                session()->flash('error', 'STK Push failed. Please try again later.');
                \Log::error($response);
                return redirect()->back();
            }

            DB::commit();

            session()->flash('success', 'Your information has been submitted successfully. Check your phone for an STK Push.');
            return redirect()->route('application.success', ['reference' => $application->application_code]);
        } catch (\Exception $exception) {
            \Log::error($exception);
            DB::rollBack();
            // session()->flash('error', 'Something went wrong. Please try again later.');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer = $this->clientRepository->find($id);

        if(!$customer){
            return response()->json(['message'=>'Client not Found']);
        }

        return response()->json(['data'=>$customer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, $id)
    {
        $client = $this->clientRepository->find($id);
        
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $data = $request->validated();

        if (empty($data)) {
            return response()->json(['message' => 'No data provided'], 422);
        }

        $client->update($data);

        return response()->json(['data' => $client], 200);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $client = $this->clientRepository->find($id);

        if(!$client){
            return response()->json(['data'=>'Client Not found'],404);

        }

        $client->delete();

        return response()->json(['message'=>'Client Deleted']);


    }

    public function applicationSuccess($reference)
    {
        return view('components.pages.application-success', ['reference' => $reference]);
    }
    public function jobapplications()
{
    // dd('hello');
    // Fetch all active job categories 
    $categories = \App\Models\JobCategory::where('status_id', 2)  
        ->get(['id', 'name', 'slug']);

    // Fetch trending jobs 
    $trendingJobs = \App\Models\Career::where('status_id', 2)  
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get(['id', 'name as title', 'description', 'job_category_id', 'slots', 'created_at']);

    // Fetch all active careers 
    $jobs = \App\Models\Career::where('status_id', 2) 
        ->with('jobCategory')
        ->orderBy('name')
         ->paginate(10);

         

    return view('components.pages.job-applications', [
        'categories' => $categories,
        'trendingJobs' => $trendingJobs,
        'jobs' => $jobs,
    ]);
}

public function jobDetails($id)
{
    $job = \App\Models\Career::with('jobCategory')
        ->findOrFail($id, ['id', 'name as title', 'description', 'job_category_id', 'slots']);

    return response()->json($job);
}
  public function count()
{
    return response()->json(['total' => Client::count()]);
}
public function getTotalPayment()
{
    $totalPayment = \App\Models\Payment::sum('amount');

    return response()->json([
        'total' => (int) $totalPayment
    ]);
}
public function getStats()
{
    $totalApplications = Application::count();
    $totalClients = Client::count();
    $totalPayments = Payment::count();
    $totalPaymentAmount = Payment::sum('amount');

    return response()->json([
        'applications' => $totalApplications,
        'clients' => $totalClients,
        'payments' => $totalPayments,
        'paymentAmount' => $totalPaymentAmount,
    ]);
}

}
