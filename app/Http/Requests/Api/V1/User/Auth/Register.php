<?php

namespace App\Http\Requests\Api\V1\User\Auth;

use App\Http\Requests\Api\V1\Master;

class Register extends Master
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'phone_code'    => 'required|exists:countries,phone_code',
            'phone'         => 'required|unique:users,phone',
            'password'      => 'required|min:6|confirmed'
        ];
    }
}
