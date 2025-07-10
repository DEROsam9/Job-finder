<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \App\Models\AppBaseModel as Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    protected $fillable = [
        'surname_name', 'first_name', 'middle_name', 'email', 'phone_number',
        'id_number', 'passport_number'
    ];
}
