<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \App\Models\AppBaseModel as Model;

class Career extends Model
{
    /** @use HasFactory<\Database\Factories\CareerFactory> */
    use HasFactory;

    protected $fillable = [
         'name', 'slug', 'description', 'job_category_id', 'status_id', 'slots'
    ];

    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
