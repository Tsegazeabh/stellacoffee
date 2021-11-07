<?php

namespace App\Http\Requests\Auth;

use App\Models\PasswordReset;
use App\Models\User;
use App\Rules\ValidUserPassword;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class PasswordResetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user_id = urldecode($this->route('id'));
        $token = urldecode($this->route('token'));
        $user = User::find($user_id);

        if (!empty($user)) {
            $passwordResetToken = PasswordReset::where('email', $user->email)->where('token', $token)->first();
            if (!empty($passwordResetToken)) {
                $now = Carbon::now();
                $differenceInMinute = $now->diffInMinutes($passwordResetToken->created_at);
                if (config('auth.passwords.users.expire') >= $differenceInMinute) {
                    return true;
                } else {
                    return false;
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
            'email' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
            'password_confirmation' => 'required'
        ];

    }
}
