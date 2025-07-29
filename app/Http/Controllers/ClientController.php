<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateClientRequest;
use App\Http\Traits\mpesa;
use App\Models\Application;
use App\Models\ApplicationPayment;
use App\Models\Client;
use App\Models\ClientDocument;
use App\Models\Payment;
use DB;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class ClientController extends Controller
{
    use mpesa;
    /**
     * Display a listing of the resource.
     */
    // Laravel (in ClientController.php)

public function index(Request $request)
{
    $query = Client::query();

    // 🔹 Grouped filtering for name OR email
    if ($request->name || $request->email) {
        $query->where(function ($q) use ($request) {
            if ($request->name) {
                $q->where('first_name', 'like', "%{$request->name}%")
                  ->orWhere('surname', 'like', "%{$request->name}%");
            }

            if ($request->email) {
                $q->orWhere('email', 'like', "%{$request->email}%");
            }
        });
    }

    // 🔹 Grouped filtering for passport OR ID
    if ($request->passport_number || $request->id_number) {
        $query->where(function ($q) use ($request) {
            if ($request->passport_number) {
                $q->where('passport_number', 'like', "%{$request->passport_number}%");
            }

            if ($request->id_number) {
                $q->orWhere('id_number', 'like', "%{$request->id_number}%");
            }
        });
    }

    // 🔹 Date filter
    if ($request->start_date && $request->end_date) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    }

    return response()->json([
        'data' => $query->latest()->paginate(10),
    ]);
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
    'first_name'       => 'required|string|max:255',
    'surname'          => 'required|string|max:255',
    'email'            => 'required|email|unique:clients,email',
    'phone_number'     => 'required|string|max:20',
    'passport_number'  => 'required|string|max:50',
    'id_number'        => 'required|string|max:50',

    // Files
    'cv'               => 'required|file|mimes:pdf,doc,docx|max:2048',
    'passport_copy'    => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
    'client_id_front'  => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
    'client_id_back'   => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',

    // Job selection
    'job_title'        => 'required|exists:careers,id',
    'job_category'     => 'nullable|exists:job_categories,id', // optional, just for chaining

    // Optional additional fields
    'remarks'          => 'nullable|string|max:255',
]);


    try {
        DB::beginTransaction();
        $input = $request->all();

        $client = Client::create([
            'surname' => $input['surname'],
            'first_name' => $input['first_name'],
            'email' => $input['email'],
            'phone_number' => $input['phone_number'],
            'passport_number' => $input['passport_number'],
            'id_number' => $input['id_number'],
        ]);

        $docFields = [
            'cv'              => null,
            'passport_copy'   => null,
            'client_id_front' => null,
            'client_id_back'  => null,
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

        $application = Application::create([
            'client_id' => $client->id,
            'career_id' => $request->get('job_title'),
            'remarks' => $request->get('experience_brief'),
        ]);

        $data = [
            'application_code' => $application->application_code,
            'phone_number'     => $client->phone_number,
            'amount'           => 1000,
        ];

        $response = $this->stkPushRequest($data);

        if (isset($response["ResponseCode"]) && $response["ResponseCode"] == "0") {
            $payment = Payment::create([
                'client_id'            => $client->id,
                'amount'               => 100,
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
        return redirect()->back();
    } catch (\Exception $exception) {
        \Log::error($exception);
        DB::rollBack();
        session()->flash('error', 'Something went wrong. Please try again later.');
        return redirect()->back();
    }
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer = Client::find($id);
        
        if(!$customer){
            return response()->json(['message'=>'Client not Found']);
        }

        return response()->json(['data'=>$customer]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateClientRequest $request, $id)
    {
        $client = Client::find($id);

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
        $client = Client::find($id);

        if(!$client){
            return response()->json(['data'=>'Client Not found'],404);

        }

        $client->delete();

        return response()->json(['message'=>'Client Deleted']);


    }
}
