<?php

namespace App\Http\Requests\Api\V1\User\Auth;

use App\Http\Requests\Api\V1\Master;

class CompleteData extends Master
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email'         => 'required|unique:users,email,' . auth('user')->id(),
            'address'       => 'required|string',
            'identity_no'   => 'required|string',
            'img'           => 'required|file|mimes:png,jpg'
        ];
    }
}
