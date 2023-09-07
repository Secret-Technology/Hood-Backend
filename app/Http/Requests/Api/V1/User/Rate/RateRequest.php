<?php

namespace App\Http\Requests\Api\V1\User\Rate;

use App\Http\Requests\Api\V1\Master;

class RateRequest extends Master
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_id'      => 'required|exists:orders,id,user_id,'.auth('user')->id(),
            'rate'          => 'nullable|numeric',
            'review'        => 'nullable|string',
        ];
    }
}
