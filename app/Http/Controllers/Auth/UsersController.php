<?php

namespace App\Http\Controllers\Auth;

use App\Events\EmailVerificationRequested;
use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Mail\UserActivationMail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRegistrationRequest $request)
    {
        try {

            DB::beginTransaction();

            $user = User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->roles()->sync($request->get('roles'));

            event(new UserRegistered($user, $request->password));

            DB::commit();
            return redirect()->intended(route('manage-accounts'));
        } catch (\Throwable $ex) {
            DB::rollBack();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return back()->withErrors(['errorMessage' => getGeneralAdminErrorMessage()]);
        }
    }

    public function resendEmailVerification($user_id)
    {
        try{
            DB::beginTransaction();
            $user= User::find($user_id);
            if(!empty($user)){
                event(new EmailVerificationRequested($user, ''));
                DB::commit();
                return response('Verification mail sent successfully', 200);
            }
            else{
                abort(404);
            }
        }
        catch (\Throwable $ex) {
            DB::rollBack();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    public function manage()
    {
        try {
            $data['pagingSize'] = getDefaultPagingSize();
            return Inertia::render('Auth/ManageUsers', $data);
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return back()->withErrors(['errorMessage' => getGeneralAdminErrorMessage()]);
        }
    }

    public function fetchUsers(Request $request)
    {
        try {
            $request['page'] = $request->get('currentPage') + 1;
            $pageSize = $request->get('pageSize');
            $sortingDirection = $request->get('sortingDirection');
            $sortingColumn = $request->get('sortingColumn');
            $result = User::with('roles')
                ->orderBy($sortingColumn, $sortingDirection)
                ->paginate($pageSize);
            return new JsonResponse($result);
        } catch (\Throwable $ex) {
            logError($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }

    public function getEdit(Request $request, $userId)
    {
        try {
            $user = User::with('roles')->find($userId);
            $data['user'] = $user;
            return Inertia::render('Auth/EditUser', $data);
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }

    public function postEdit(EditUserRequest $request, $userId)
    {
        try {
            DB::beginTransaction();
            $user = User::with('roles')->find($userId);
            if (!empty($user)) {
                $user->update($request->except(['roles', 'password', 'password_confirmation', 'terms']));
                $user->roles()->sync($request->get('roles'));
                DB::commit();
                return redirect(route('manage-accounts'));
            } else {
                return back()->withErrors(['errorMessage' => 'User with the specified id is not found']);
            }
        } catch (\Throwable $ex) {
            DB::rollBack();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return back()->withErrors(['errorMessage' => getGeneralAdminErrorMessage()]);
        }
    }

    public function toggleStatus(Request $request, $userId)
    {
        try {
            $user = User::find($userId);
            if (!empty($user)) {
                $user->account_disabled = !$user->account_disabled;
                $user->save();
                return new JsonResponse(getUserStatusUpdatedNotificationMessage());
            }
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return new JsonResponse(getUnableToUpdateUserStatusNotificationMessage(), 503);
        }
    }
}

