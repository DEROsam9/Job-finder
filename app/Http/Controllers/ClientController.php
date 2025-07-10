<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Career;
use App\Models\Client;
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

//        $data = $request->validated();

        dd($request->all());

        // Store files
        $data['id_front'] = $request->file('id_front')->store('uploads/id_cards', 'public');
        $data['passport_copy'] = $request->file('passport_copy')?->store('uploads/passports', 'public');
        $data['good_conduct'] = $request->file('good_conduct')?->store('uploads/good_conducts', 'public');
        $data['cv'] = $request->file('cv')->store('uploads/cvs', 'public');

        Client::create([
            'surname', 'first_name', 'middle_name', 'email', 'phone_number', 'passport_number', 'id_number',
        ]);

        // Save to the jobs table
        Career::create($data);

        return redirect()->back()->with('success', 'Your information has been submitted successfully.');
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
