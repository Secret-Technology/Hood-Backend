<?php

namespace App\Http\Requests\Api\V1\User\User;

use App\Http\Requests\Api\V1\Master;

class UpdateProfile extends Master
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name'    => 'nullable|string',
            'last_name'     => 'nullable|string',
            'phone_code'    => 'nullable|exists:countries,phone_code',
            'phone'         => 'nullable|unique:users,phone,' . auth('user')->id() . 'phone_code' . $this->phone_code,
            'email'         => 'nullable|unique:users,email,' . auth('user')->id(),
            'address'       => 'nullable|string',
            'identity_no'   => 'nullable|string',
            'img'           => 'nullable|file|mimes:png,jpg'
        ];
    }
}
