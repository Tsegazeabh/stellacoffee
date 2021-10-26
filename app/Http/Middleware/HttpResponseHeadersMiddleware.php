<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use function PHPUnit\Framework\isEmpty;

class HttpResponseHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

//        Inertia::share([
//            'nonce' => app('csp-nonce')
//        ]);

        header_remove('X-Powered-By');
        $response = $next($request);
        if (method_exists($response,'header')) {
            $response->header('Strict-Transport-Security', 'max-age=31536000');
            $response->header('X-Content-Type-Options', 'nosniff');
            $response->header('X-XSS-Protection', '1; mode=block');
            $response->header('X-Frame-Options', 'SAMEORIGIN');
        }
        return $response;
    }
}
