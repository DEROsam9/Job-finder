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

    public function status()
{
    return $this->belongsTo(Status::class, 'status_id');
}
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function applicationPayment() {
        return $this->hasOne(ApplicationPayment::class, 'payment_id')->with('application');
    }
    // app/Models/Payment.php
public function applications()
{
    return $this->belongsToMany(Application::class, 'application_payments')
                ->withPivot('amount', 'balance')
                ->withTimestamps();
}
}
