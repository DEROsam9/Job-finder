<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \App\Models\AppBaseModel as Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    protected $fillable = [
        'surname', 'first_name', 'middle_name', 'status_id', 'email', 'phone_number', 'passport_number', 'id_number', 'address', 'city'
    ];

    public function applications()
{
    return $this->hasMany(Application::class);
}

public function documents()
{
    return $this->hasMany(ClientDocument::class);
}

}

