<?php

namespace App\Http\Requests\Api\V1\User\Auth;

use App\Http\Requests\Api\V1\Master;

class LoginWithOtp extends Master
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'phone_code' => 'required|exists:users,phone_code',
            'phone' => 'required|exists:users,phone',
            'otp' => 'required|exists:users,otp'
        ];
    }
}
