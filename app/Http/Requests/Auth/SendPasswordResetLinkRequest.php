<?php

namespace App\Http\Requests\Auth;

use App\Mail\PasswordResetLinkMail;
use App\Mail\UserActivationMail;
use App\Models\EmailVerificationToken;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) {
            if ($this->route()->hasParameter('id')) {
                $user = User::find($this->route('id'));
                if (!empty($user)) {
                    return $user->isActive() && !$user->is_admin;
                }
            }
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Send password reset link to user's email address
     * @throws \Exception
     */
    public function sendResetLinkMail()
    {
        if ($this->route()->hasParameter('id')) {

            $user = User::find($this->route('id'));

            // generate password reset token
            $token = md5(random_bytes(32));

            // delete previous password reset tokens
            PasswordReset::destroy($user->email);

            // create new password reset token
            PasswordReset::create([
                'email' => $user->email,
                'token' => $token
            ]);
            Mail::send(new PasswordResetLinkMail($user->id, $user->email, $user->first_name, $token));
        }

    }
}
