<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Repositories\PaymentRepository;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;

class PaymentController extends Controller
{
    /**
     * List all payments with pagination
     */
      private PaymentRepository $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }
   public function index(Request $request)
{

    $payments = $this->paymentRepository
        ->with(['status', 'client'])
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


        
        // (rest of filters unchanged)
        ->orderBy($request->get('orderBy', 'created_at'), $request->get('sortedBy', 'desc'))
        ->paginate($request->get('limit', 20));

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
}
