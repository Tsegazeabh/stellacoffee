<?php

namespace App\Http\Controllers\Auth\Customized;

use App\Http\Controllers\Controller;
//use App\Http\Requests\Auth\EmailVerificationRequest;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param EmailVerificationRequest $request
     * @param $userId
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->verifyEmail();
            DB::commit();
            return redirect()->intended(route('login'));
        } catch (\Throwable $ex) {
            DB::rollBack();
            $data['errorMessage'] = getGeneralAdminErrorMessage();
            return Inertia::render('Errors/UnhandledException', $data);
        }
    }

    public function notifyUnverifiedEmail($request)
    {
        try {
            if(Auth::check()) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
            return Inertia::render('Auth/VerifyEmail');
        } catch (\Throwable $ex) {
            report($ex);
            if ($ex instanceof NotFound) {
                abort(404);
            }

            abort(403, 'Your email is not verified');
        }
    }
}
