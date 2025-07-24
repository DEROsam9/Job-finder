<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \App\Models\AppBaseModel as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Status extends Model
{
    /** @use HasFactory<\Database\Factories\StatusFactory> */
    use HasFactory,SoftDeletes;

    protected $table = 'statuses';

    protected $fillable = ['name', 'code'];

    public function payments()
{
    return $this->hasMany(Payment::class);
}
    public function applications()
{
    return $this->hasMany(Application::class);
}
}