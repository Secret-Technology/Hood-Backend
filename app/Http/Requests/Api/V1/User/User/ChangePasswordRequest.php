<?php

namespace App\Http\Requests\Api\V1\User\User;

use App\Http\Requests\Api\V1\Master;

class ChangePasswordRequest extends Master
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'old_password'  => 'required',
            'password'      => 'required|min:6|confirmed',
        ];
    }
}
