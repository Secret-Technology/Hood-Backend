<?php

namespace App\Http\Requests\Api\V1\User\Order;

use App\Http\Requests\Api\V1\Master;

class OrderRequest extends Master
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'from'              => 'required|array',
            'from.lat'          => 'nullable|numeric',
            'from.lng'          => 'nullable|numeric',
            'from.location'     => 'nullable|string|between:2,250',

            'to'                => 'required|array',
            'to.lat'            => 'nullable|numeric',
            'to.lng'            => 'nullable|numeric',
            'to.location'       => 'nullable|string|between:2,250',

            'extra_routes'            => 'nullable|array',
            'extra_routes.*.lat'      => 'nullable|numeric',
            'extra_routes.*.lng'      => 'nullable|numeric',
            'extra_routes.*.location' => 'nullable|string|between:2,250',

            'distance'          => 'required|string',
            'time'              => 'required|string',
            'google_route'      => 'required|array',

            'note'              => 'nullable|string',

            'user_fare_price'   => 'required|string',

            'package_id'        => 'required|exists:packages,id',

            'payment_type'      => 'nullable|in:cash,wallet,digital',

            'sender_number'     => 'nullable|string',
            'sender_name'       => 'nullable|string',

            'receiver_number'   => 'nullable|string',
            'receiver_name'     => 'nullable|string',

            'parcel_dimension'  => 'nullable|string',
            'parcel_weight'     => 'nullable|string',

            'how_pay'           => 'nullable|in:receiver,sender',

            'parcel_category_id'=> 'nullable|exists:parcel_categories,id',
        ];
    }
}
