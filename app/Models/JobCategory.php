<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \App\Models\AppBaseModel as Model;

class JobCategory extends Model
{
    /** @use HasFactory<\Database\Factories\JobCategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'status_id'];

      // Add this relationship
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    
     public function careers()
    {
        return $this->hasMany(Career::class);
    }
}
