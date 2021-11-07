<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $appends=['model_name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, "role_permissions", "permission_id", "role_id")->withTimestamps();
    }

    public  function getModelNameAttribute(){
        return getModelShortName($this->model);
    }

}
