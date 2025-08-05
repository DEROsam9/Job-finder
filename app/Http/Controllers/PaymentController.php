<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * List all payments with pagination
     */
public function index(Request $request)
{
    $query = Payment::with(['status', 'client'])->latest();

    if ($request->filled('name_email')) {
        $nameEmail = $request->input('name_email');
        $query->whereHas('client', function ($q) use ($nameEmail) {
            $q->where('first_name', 'like', "%$nameEmail%")
              ->orWhere('middle_name', 'like', "%$nameEmail%")
              ->orWhere('surname', 'like', "%$nameEmail%")
              ->orWhere('email', 'like', "%$nameEmail%");
        });
    }

    if ($request->filled('passport_id')) {
        $query->whereHas('client', function ($q) use ($request) {
            $q->where('passport_number', 'like', "%{$request->input('passport_id')}%");
        });
    }

    if ($request->filled('status')) {
        $query->whereHas('status', function ($q) use ($request) {
            $q->where('name', $request->input('status'));
        });
    }

    if ($request->filled('date_from') && $request->filled('date_to')) {
        $query->whereBetween('transaction_date', [
            $request->input('date_from'),
            $request->input('date_to')
        ]);
    }

    $payments = $query->paginate($request->get('limit', 20));

    return response()->json([
        'data' => $payments
    ]);
}




    /**
     * Store a new payment
     */
    public function store(StorePaymentRequest $request)
    {
          \Log::info('Entered PaymentController@store');
        $payment = Payment::create($request->validated());

        return response()->json([
            'message' => 'Payment created successfully',
            'data' => $payment
        ], 201);
        
    }

    /**
     * Show a single payment
     */
    public function show(Payment $payment)
    {
        return response()->json([
            'data' => $payment
        ]);
    }

    /**
     * Update an existing payment
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());

        return response()->json([
            'message' => 'Payment updated successfully',
            'data' => $payment
        ]);
    }

    /**
     * Delete a payment
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json([
            'message' => 'Payment deleted successfully'
        ]);
    }
      public function count()
{
    return response()->json(['total' => Payment::count()]);
}
}
