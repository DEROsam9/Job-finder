<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationPayment extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationPaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id', 'payment_id', 'application_id', 'amount', 'balance'
    ];

    public function client()
{
    return $this->belongsTo(\App\Models\Client::class);
}
    public function payment()
{
    return $this->belongsTo(Payment::class);
}

    public function application()
{
    return $this->belongsTo(Application::class);

}
}