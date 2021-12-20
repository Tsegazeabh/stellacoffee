<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use League\Flysystem\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Inertia::share([
            'locale' => function () {
                return app()->getLocale();
            },
            'language' => function () {
                return translations(
                    resource_path('lang/' . app()->getLocale() . '/vue-translations.json')
                );
            },
            'free_call_center' => config('custom_config.free_call_center'),
            'facebook_official_page' => config('custom_config.facebook_official_page'),
            'twitter_official_page' => config('custom_config.twitter_official_page'),
            'telegram_official_page' => config('custom_config.telegram_official_page'),
            'youtube_official_page' => config('custom_config.youtube_official_page'),
            'linkedin_official_page' => config('custom_config.linkedin_official_page'),
            'instagram_official_page' => config('custom_config.instagram_official_page')
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
