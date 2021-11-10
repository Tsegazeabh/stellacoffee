<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

function getAuthorizableModels()
{
    return array(

    );
}

function isAuthorized($model, $action, User $user)
{
    if($user->is_admin){
        return true;
    }

    $userId = $user->getAuthIdentifier();

    return Role::whereHas('users', function ($query) use ($userId) {
        $query->where('users.id', $userId);
    })->whereHas('permissions', function ($query) use ($model, $action) {
        $query->where('model', $model)->where('action', $action);
    })->exists();
}
