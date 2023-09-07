<?php

namespace App\Http\Resources\Api\V1\User\Order;

use App\Http\Resources\Api\V1\User\ParcelCategory\ParcelCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParcelDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sender_number' => @$this->sender_number,
            'sender_name' => @$this->sender_name,
            'receiver_number' => @$this->receiver_number,
            'receiver_name' => @$this->receiver_name,
            'parcel_dimension' => @$this->parcel_dimension,
            'parcel_weight' => @$this->parcel_weight,
            'how_pay' => @$this->how_pay,
            'parcel_category' => @$this->parcel_category ? ParcelCategoryResource::make($this->parcel_category) : null,
        ];
    }
}
