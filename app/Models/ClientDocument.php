<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'remarks',
        'document_type',
        'passport_expiry_date',
        'document_url'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
