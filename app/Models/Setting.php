<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable=['name','email','phone','kra_Pin','location','address','email_configs','letter_head','logo'];
}
