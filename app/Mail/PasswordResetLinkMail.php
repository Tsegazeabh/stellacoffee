<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userId;
    public $userEmail;
    public $userfirstName;
    public $token;

    /**
     * Create a new message instance.
     *
     * @param $userId
     * @param $userEmail
     * @param $userfirstName
     * @param $token
     */
    public function __construct($userId, $userEmail, $userfirstName, $token)
    {
        $this->userId = $userId;
        $this->userEmail = $userEmail;
        $this->userfirstName = $userfirstName;
        $this->token = $token;
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
            ->subject('Your '.env('APP_NAME').' Account Password Reset Token')
            ->view('Emails.PasswordResetLinkMail');
    }
}
