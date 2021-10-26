<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\UserActivationMail;
use App\Models\EmailVerificationToken;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailVerificationMessage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserRegistered $event
     * @return void
     * @throws \Exception
     */
    public function handle(UserRegistered $event)
    {
        $token = md5(random_bytes(32));
        $_ = EmailVerificationToken::create(['id' => $event->user->id, 'token' => $token]);
        Mail::send(new UserActivationMail($event->user->id, $event->user->email, $event->plain_passwd, $token));
    }
}
