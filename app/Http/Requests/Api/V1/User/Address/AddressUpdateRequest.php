<?php

namespace App\Http\Requests\Api\V1\User\Address;

use App\Http\Requests\Api\V1\Master;

class AddressUpdateRequest extends Master
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'      => 'nullable|string|max:45',
            'location'  => 'nullable|string|max:225',
            'lat'       => 'nullable|string|max:225',
            'lng'       => 'nullable|string|max:225',
        ];
    }
}
