<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id', 'amount', 'status_id', 'additional_information', 'payload', 'transaction_reference', 'transaction_date', 'remarks', 'merchant_request_id', 'checkout_request_id'
    ];
}
