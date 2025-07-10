<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AppBaseModel extends Model
{
    protected $primaryKey = 'id';

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            if (in_array('created_by',$model->fillable) && empty($model->created_by)){
                $model->created_by = Auth::user()->id;
            }

            $generateUniqueCode = function($field, $prefix) {
                $maxCode = 9999;
                $codeLength = strlen((string)$maxCode);

                do {
                    $code = mt_rand(1000, $maxCode);
                    $formattedCode = $prefix . str_pad($code, $codeLength, '0', STR_PAD_LEFT);

                    if (self::where($field, $formattedCode)->exists()) {
                        $maxCode = pow(10, $codeLength) - 1;
                        $codeLength++;
                    }
                } while (self::where($field, $formattedCode)->exists());

                return $formattedCode;
            };

            if (in_array('application_code', $model->fillable) && empty($model->application_code)) {
                $model->application_code = $generateUniqueCode('application_code', 'APC');
            }

            if (in_array('status_id',$model->fillable) && empty($model->status_id))
                $model->status_id = Status::where('code','ACTIVE')->first()->id;
        });

        static::retrieved(function ($model) {

            $exclude_uppercase=['modules'];

            if(Schema::hasColumn($model->table, 'surname')){

                if (is_string($model->surname)){
                    $model->surname =trim(strtoupper($model->surname));
                }else{
                    $model->surname ="";
                }
            }

            if(Schema::hasColumn($model->table, 'first_name')){

                if (is_string($model->first_name)){
                    $model->first_name =trim(strtoupper($model->first_name));
                }else{
                    $model->first_name ="";
                }
            }

            if(Schema::hasColumn($model->table, 'middle_name')){
                if (is_string($model->middle_name)){
                    $model->middle_name =trim(strtoupper($model->middle_name));
                }else{
                    $model->middle_name ="";
                }
            }

            if(Schema::hasColumn($model->table, 'last_name')){
                if (is_string($model->last_name)){
                    $model->last_name =trim(strtoupper($model->last_name));
                }else{
                    $model->last_name ="";
                }
            }

            if(!in_array('modules',$exclude_uppercase) && $model->table!==Schema::hasColumn($model->table, 'name')){
                if (is_string($model->name)){
                    $model->name =trim(strtoupper($model->name));
                }else{
                    $model->name ="";
                }
            }

            if(Schema::hasColumn($model->table, 'email')){
                if (is_string($model->email)){
                    $model->email =trim(strtoupper($model->email));
                }else{
                    $model->email="";
                }
            }

            if(Schema::hasColumn($model->table, 'model')){
                if (is_string($model->model)){
                    $model->model =trim(strtoupper($model->model));
                }else{
                    $model->model="";
                }
            }

            if(Schema::hasColumn($model->application_code, 'application_code')){
                if (is_string($model->application_code)){
                    $model->application_code =trim(strtoupper($model->application_code));
                }else{
                    $model->application_code="";
                }
            }

            if(Schema::hasColumn($model->table, 'name')){
                if (is_string($model->name)){
                    $model->name =trim(strtoupper($model->name));
                }else{
                    $model->name ="";
                }
            }
        });
    }
}
