<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ValidUserPassword implements Rule
{
    public $userId = '';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::where('id', $this->userId)->first();
        return Auth::attempt(['email' => $user->email, 'password' => $value, 'account_disabled' => 0]);
//        return User::where('id', $this->userId) ->where('password', Hash::make($value))->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid current password.';
    }
}
