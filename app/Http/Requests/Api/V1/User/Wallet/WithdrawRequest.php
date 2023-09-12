<?php

namespace App\Http\Requests\Api\V1\User\Wallet;

use App\Http\Requests\Api\V1\Master;

class WithdrawRequest extends Master
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount'  => 'required|numeric|min:0|max:'.auth('user')->user()->wallet,
        ];
    }
}
