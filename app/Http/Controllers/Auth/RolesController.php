<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EditRoleRequest;
use App\Http\Requests\Auth\RoleRegistrationRequest;
use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;

class RolesController extends Controller
{
    //

    public function __construct() { }

    protected function index()
    {
        try {
            $data['pagingSize']= getDefaultPagingSize();
            return Inertia::render('Auth/Roles', $data);
        }
        catch (\Throwable $ex){
            report($ex);
            if($ex instanceof AuthorizationException){
                abort(403);
            }
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    public function fetchRoles(Request $request)
    {
        try {
            $request['page'] = $request->get('currentPage') + 1;
            $pageSize = $request->get('pageSize');
            $sortingDirection = $request->get('sortingDirection');
            $sortingColumn = $request->get('sortingColumn');
            $result = Role::where('name', '!=', 'SuperAdmin')
                ->withCount('users')
                ->orderBy($sortingColumn, $sortingDirection)
                ->paginate($pageSize);
            return response($result);
        } catch (\Throwable $ex) {
            logError($ex);
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    protected function getAllRoles(Request $request)
    {
        try {
            $roles = Role::where('name', '!=', 'SuperAdmin')->get();
            return response($roles);
        } catch (\Throwable $ex) {
            report($ex);
            logError($ex);
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    protected function getRole($id)
    {
        try
        {
            $role = Role::find($id);
            if(!empty($role)) {
                return response($role);
            }
            else{
                return response('unknown role', 503);
            }
        }

        catch (\Throwable $ex){
            report($ex);
            if($ex instanceof AuthorizationException){
                abort(403);
            }
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    protected function addRole(RoleRegistrationRequest $request)
    {
        try
        {
            Role::create($request->all());
            return response('Role is created successfully!', 200);
        }

        catch (\Throwable $ex){
            report($ex);
            if($ex instanceof AuthorizationException){
                abort(403);
            }
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    protected function editRole(EditRoleRequest $request, $id){
        try
        {
            $role = Role::find($id);
            if(!empty($role)){
                $role->update($request->all());
                return response('Your changes are applied successfully!', 200);
            }
            else
                {
                return response('The role you are trying to edit does not exist on the system!', 503);
            }
        }
        catch (\Throwable $ex){
            report($ex);
            if($ex instanceof AuthorizationException){
                abort(403);
            }
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    protected  function deleteRole($id)
    {
        try
        {
            $role = Role::find($id);
            if(!empty($role)){
                Role::destroy($id);
                return response('Role deleted successfully!', 200);
            }
            else
            {
                return response('The role you are trying to edit does not exist on the system!', 503);
            }
        }
        catch (\Throwable $ex){
            report($ex);
            if($ex instanceof AuthorizationException){
                abort(403);
            }
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }
}
