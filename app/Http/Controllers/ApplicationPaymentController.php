<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationPaymentRequest;
use App\Http\Requests\UpdateApplicationPaymentRequest;
use App\Models\ApplicationPayment;
use Illuminate\Http\Request;

class ApplicationPaymentController extends Controller
{
    public function index(Request $request)
    {
        $data = ApplicationPayment::paginate($request->get('limit', 20));

        return response()->json([
            'data' => $data
        ], 200);
    }

    public function store(StoreApplicationPaymentRequest $request)
    {
        $applicationPayment = ApplicationPayment::create($request->validated());

        return response()->json([
            'message' => 'Application payment created successfully',
            'data' => $applicationPayment
        ], 201);
    }

    public function show( $id)
    {
        $applicationPayment = ApplicationPayment::find($id);
        if(!$applicationPayment){
            return response()->json([
                "message"=>"user not found"
            ],404);
        }
        return response()->json([
            'data' => $applicationPayment
        ], 200);
    }

    public function update(UpdateApplicationPaymentRequest $request, ApplicationPayment $applicationPayment)
    {
        $applicationPayment->update($request->validated());

        return response()->json([
            'message' => 'Application payment updated successfully',
            'data' => $applicationPayment
        ], 200);
    }

    public function destroy(ApplicationPayment $applicationPayment)
    {
        $applicationPayment->delete();

        return response()->json([
            'message' => 'Application payment deleted successfully'
        ], 200);
    }
}
