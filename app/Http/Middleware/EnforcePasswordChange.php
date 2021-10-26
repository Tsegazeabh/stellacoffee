<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnforcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->passwordModified()){
            return $next($request);
        }

        else{
            return redirect()->intended(route('password-modification-page', $request->user()->id));
        }
    }
}
