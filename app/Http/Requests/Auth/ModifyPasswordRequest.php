<?php

namespace App\Http\Requests\Auth;

use App\Rules\ValidUserPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ModifyPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $password_validator = new Password(8);
        $user_id = $this->route()->parameters()['userId'];
        return [
            'old_password' => ['required', new ValidUserPassword($user_id)],
            'new_password' =>  ['required', 'confirmed', 'different:old_password', Password::min(8), $password_validator->letters(), $password_validator->symbols()],
            'new_password_confirmation' => 'required'
        ];
    }
}
