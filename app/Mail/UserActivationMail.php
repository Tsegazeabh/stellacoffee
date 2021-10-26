<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userId;
    public $userEmail;
    public $token;
    public $plain_passwd;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userId, $userEmail, $plain_passwd, $token)
    {
        $this->userId = $userId;
        $this->userEmail = $userEmail;
        $this->token = $token;
        $this->plain_passwd = $plain_passwd;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->to($this->userEmail)
                    ->subject('Your EEU Account Activation Token')
                    ->view('Emails.UserActivationMail');
    }
}
