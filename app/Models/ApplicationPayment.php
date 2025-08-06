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

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    return $this->belongsTo(\App\Models\Client::class);
}
    public function payment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    return $this->belongsTo(Payment::class);
}

public function application() : \Illuminate\Database\Eloquent\Relations\BelongsTo
{
    return $this->belongsTo(Application::class)->with('career:id,name');

}
}
