<?php

namespace App\Listeners;

use App\Events\EmailVerificationRequested;
use App\Mail\UserActivationMail;
use App\Models\EmailVerificationToken;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ResendEmailVerification
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
     * @param object $event
     * @return void
     * @throws \Exception
     */
    public function handle(EmailVerificationRequested $event)
    {
        $token = md5(random_bytes(32));
        $prevToken = EmailVerificationToken::find($event->user->id);
        if (!empty($prevToken)) {
            $prevToken->token=$token;
            $prevToken->created_at = Carbon::now();
            $prevToken->save();
        }
        else {
            $_ = EmailVerificationToken::create(['id' => $event->user->id, 'token' => $token]);
        }

        Mail::send(new UserActivationMail($event->user->id, $event->user->email, $event->plain_passwd, $token));
    }
}
