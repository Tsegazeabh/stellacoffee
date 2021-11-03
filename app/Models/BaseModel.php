<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Authorizable
{
    use SoftDeletes, HasFactory;

    public static function boot(){
        parent::boot();

        static::creating(function ($model){
            $user= Auth::user();
            $model->created_by = $user->id;
        });

        static::updating(function ($model){
            $user= Auth::user();
            $model->updated_by = $user->id;
        });

        static::deleting(function($model){
            if(!$model->forceDeleting){
                $user = Auth::user();
                $model->deleted_by = $user->id;
            }
        });
    }
}
