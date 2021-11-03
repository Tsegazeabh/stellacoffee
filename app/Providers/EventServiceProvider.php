<?php

namespace App\Providers;

use App\Events\ContentVisited;
use App\Events\EmailVerificationRequested;
use App\Events\UserRegistered;
use App\Listeners\LogContentVisit;
use App\Listeners\ResendEmailVerification;
use App\Listeners\SendEmailVerificationMessage;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        UserRegistered::class => [
            SendEmailVerificationMessage::class
        ],

        EmailVerificationRequested::class => [
            ResendEmailVerification::class
        ],

        ContentVisited::class => [
            LogContentVisit::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
