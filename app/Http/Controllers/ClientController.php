<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Application;
use App\Models\Career;
use App\Models\Client;
use App\Models\ClientDocument;
use DB;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            DB::beginTransaction();
            $input = $request->all();

            $client = Client::create([
                'surname' => $input['surname'],
                'first_name' => $input['first_name'],
                'middle_name' => $input['middle_name'],
                'email' => $input['email'],
                'phone_number' => $input['phone_number'],
                'passport_number' => $input['passport_number'],
                'id_number' => $input['id_number'],
            ]);

            $docFields = [
                'cv'            => null,
                'good_conduct'  => null,
                'passport_copy' => 'passport_expiry_date',
                'id_card'       => null,
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

            Application::create([
                'client_id' => $client->id,
                'career_id' => $request->get('job_title'),
                'remarks' => $request->get('experience_brief'),
            ]);


            DB::commit();

            return redirect()->back()->with('success', 'Your information has been submitted successfully.');
        } catch (\Exception $exception) {
            \Log::info($exception);
            \DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
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
    public function update(UpdateClientRequest $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
