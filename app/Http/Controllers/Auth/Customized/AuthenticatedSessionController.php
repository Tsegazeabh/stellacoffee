<?php

namespace App\Http\Controllers\Auth\Customized;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CustomLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\CustomLoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(CustomLoginRequest $request)
    {
        try {
            $request->authenticate();

            $request->session()->regenerate();

            if(!$request->user()->passwordModified()){
                return redirect()->intended(route('password-modification-page', $request->user()->id));
            }

            return redirect()->intended(route(RouteServiceProvider::HOME));
        } catch (\Throwable $ex) {
            if ($ex instanceof ValidationException) {
                return back()->withErrors($ex->errors());
            }

            return back()->withErrors(['errorMessage' => $ex->getMessage()]);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
