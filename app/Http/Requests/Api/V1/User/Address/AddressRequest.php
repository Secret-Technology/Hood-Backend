<?php

namespace App\Http\Requests\Api\V1\User\Address;

use App\Http\Requests\Api\V1\Master;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends Master
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:45',
            'location'  => 'required|string|max:225',
            'lat'       => 'required|string|max:225',
            'lng'       => 'required|string|max:225',
        ];
    }
}
