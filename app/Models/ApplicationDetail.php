<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationDetail extends Model
{
      protected $fillable = [
        'application_id','career_id', 'status_id', 
    ];


     public function application()
    {
        return $this->belongsTo(Application::class);
    }


    public function career()
{
    return $this->belongsTo(Career::class);
}

public function status()
{
    return $this->belongsTo(Status::class);
}
}
