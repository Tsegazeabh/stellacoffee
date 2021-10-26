<?php

namespace App\Providers;

use App\Models\Locale;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class LocaleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        try {
            $default_locale = Config::get('app.fallback_locale');
            $default_locale_id = Locale::where('short_code', $default_locale)->first()->id;
            $this->app->singleton('DefaultLocaleID', function ($app) use ($default_locale_id) {
                return $default_locale_id;
            });
        }
        catch (\Throwable $ex){

        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
