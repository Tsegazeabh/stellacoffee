<?php

namespace App\Http\Middleware;

use App\Models\Locale;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class i18n
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
        try {
            if ($request->has('lang')) {
                $langCode = $request->get('lang');
                $locale = Locale::where('short_code', $langCode)->first();
                if (!empty($locale)) {
                    Session::put('lang_id', $locale->id);
                } else {
                    $langCode = Session::get('lang', Config::get('app.fallback_locale'));
                }
                Session::put('lang', $langCode);
            } else {
                $langCode = Session::get('lang', Config::get('app.fallback_locale'));
            }

            if (app()->getLocale() != $langCode) {
                app()->setLocale($langCode);
            }
        } catch (\Throwable $ex) {
            logError($ex);
        }
        return $next($request);
    }
}
