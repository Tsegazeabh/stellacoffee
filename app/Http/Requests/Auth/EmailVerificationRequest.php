<?php

namespace App\Http\Requests\Auth;

use App\Models\EmailVerificationToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class EmailVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $token = urldecode($this->route('hash'));
        $emailVerification = EmailVerificationToken::where('id', $this->route('id'))->where('token', $token)->first();

        if (!empty($emailVerification)) {
            $now = Carbon::now();
            $differenceInMinute = $now->diffInMinutes($emailVerification->created_at);
            if (config('auth.verification_token_timeout') >= $differenceInMinute) {
                return true;
            } else {
                return false;
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

        ];
    }

    public function verifyEmail()
    {
        $now = Carbon::now();
        $user = User::find($this->route('id'));
        if (!$user->hasVerifiedEmail()) {
            $emailVerification = EmailVerificationToken::find($this->route('id'));
            $user->email_verified_at = $now;
            $emailVerification->forceDelete();
            $user->save();
        }
    }
}
