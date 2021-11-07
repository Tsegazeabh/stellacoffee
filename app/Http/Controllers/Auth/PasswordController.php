<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ModifyPasswordRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Http\Requests\Auth\SendPasswordResetLinkRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    function __construct()
    {
    }

    /**
     * @param Request $request
     * @param $userId
     * @return \Inertia\Response
     */
    protected function getModifyPassword(Request $request, $userId)
    {
        try {
            if (User::where('id', $userId)->exists()) {
                $data['userId'] = $userId;
                return Inertia::render('Auth/ModifyPassword', $data);
            } else {
                $data['errorMessage'] = getGeneralAdminErrorMessage();
                return Inertia::render('Errors/UnhandledException', $data);
            }
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            $data['errorMessage'] = getGeneralAdminErrorMessage();
            return Inertia::render('Errors/UnhandledException', $data);
        }
    }

    /**
     * @param ModifyPasswordRequest $request
     * @param $userId
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function postModifyPassword(ModifyPasswordRequest $request, $userId)
    {
        try {
            if (User::where('id', $userId)->exists()) {
                $user = User::find($userId);
                $user->password = Hash::make($request->get('new_password'));
                $user->must_change_password = false;
                $user->password_modification_date= Carbon::now();
                $user->save();
                return back()->with(['userId' => $userId]);
            } else {
                $data['errorMessage'] = getGeneralAdminErrorMessage();
                return Inertia::render('Errors/UnhandledException', $data);
            }
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            $data['errorMessage'] = getGeneralAdminErrorMessage();
            return Inertia::render('Errors/UnhandledException', $data);
        }
    }

    /**
     * @param SendPasswordResetLinkRequest $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function sendPasswordResetLink(SendPasswordResetLinkRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->sendResetLinkMail();
            DB::commit();
            return $request->wantsJson() ? new JsonResponse('Password reset link sent successfully') :
                back()->with(['successMessage' => 'Password reset link sent successfully']);
        } catch (\Throwable $ex) {
            DB::rollBack();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) :
                back()->withErrors(['errorMessage' => getGeneralAdminErrorMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @param $token
     * @return \Inertia\Response
     */
    protected function getResetPassword(Request $request, $id, $token)
    {
        try {
            $user = User::find($id);
            if (!empty($user)) {
                $passwordRestToken = PasswordReset::find($user->email);
                $token = urldecode($token);
                if (!empty($passwordRestToken)) {
                    if ($token == $passwordRestToken->token) {
                        $now = Carbon::now();
                        $differenceInMinute = $now->diffInMinutes($passwordRestToken->created_at);
                        if (config('auth.passwords.users.expire') >= $differenceInMinute) {
                            $data['email'] = $user->email;
                            $data['token'] = $passwordRestToken->token;
                            $data['user_id'] = $user->id;
                            return Inertia::render('Auth/ResetPassword', $data);
                        } else {
                            $data['errorMessage'] = 'Your password reset token is expired.';
                            return Inertia::render('Errors/UnhandledException', $data);
                        }
                    } else {
                        $data['errorMessage'] = 'Invalid password reset token.';
                        return Inertia::render('Errors/UnhandledException', $data);
                    }
                }
            } else {
                $data['errorMessage'] = 'Invalid password reset token.';
                return Inertia::render('Errors/UnhandledException', $data);
            }
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            $data['errorMessage'] = getGeneralAdminErrorMessage();
            return Inertia::render('Errors/UnhandledException', $data);
        }
    }

    /**
     * @param PasswordResetRequest $request
     * @param $id
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function postResetPassword(PasswordResetRequest $request, $id, $token)
    {
        try {
            $user = User::find($id);
            if (!empty($user)) {
                $passwordRestToken = PasswordReset::find($user->email);
                $token = urldecode($token);
                if (!empty($passwordRestToken)) {
                    if ($token == $passwordRestToken->token) {
                        $user->password = Hash::make($request->get('password'));
                        $user->must_change_password = false;
                        $user->password_modification_date= Carbon::now();
                        $user->save();
                        return redirect()->intended(route('login'));
                    }
                }
                return back()->withErrors(['errorMessage' => 'Invalid password reset token']);
            } else {
                return back()->withErrors(['errorMessage' => getGeneralAdminErrorMessage()]);
            }
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return back()->withErrors(['errorMessage' => getGeneralAdminErrorMessage()]);
        }
    }
}
