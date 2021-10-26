<?php

namespace App\Providers;

use App\Services\IRSSCampaign;
use App\Services\MailChimpCampaign;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class RSSCampaignServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(IRSSCampaign::class, MailChimpCampaign::class);
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
