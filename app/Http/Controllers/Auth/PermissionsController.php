<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PermissionsController extends Controller
{
    function __construct()
    {
    }

    protected function index(Request $request)
    {
        try {
            return Inertia::render('Auth/Permission');
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return Inertia::render('Errors/404');
        }
    }

    protected function getPermissions(Request $request)
    {
        try {
            $permissions = Permission::get();

            return response($permissions->groupBy('model'));
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    protected function getRolePermissions(Request $request, $role_id)
    {
        try {
            $role_permissions = Permission::whereHas('roles', function ($query) use ($role_id) {
                return $query->where('roles.id', $role_id);
            })->select('id')->get();
            return response($role_permissions);
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    protected function updateRolePermissions(Request $request, $role_id)
    {
        DB::beginTransaction();
        try {
            $permissions = $request->get('permissions');
            $role = Role::find($role_id);
            $role->permissions()->sync($permissions);
            DB::commit();
            return $request->wantsJson() ? new JsonResponse('Permissions updated') : back()->with('successMessage', 'Permissions updated');
        } catch (\Throwable $ex) {
            DB::rollBack();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }
}
