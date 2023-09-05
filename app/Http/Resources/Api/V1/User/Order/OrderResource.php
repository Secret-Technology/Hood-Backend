<?php

namespace App\Http\Resources\Api\V1\User\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'distance' => $this->distance,
            'time' => $this->time,
            'payment_type' => $this->payment_type,
            'note' => $this->note,
            'fare_price' => $this->fare_price,
            'user_fare_price' => $this->user_fare_price,
            'accepted_fare_price' => $this->accepted_fare_price,
            'driver_fare' => $this->driver_fare,
            'tip' => $this->tip,
            'from' => $this->address->from,
            'to' => $this->address->to,
            'is_parcel' => $this->package->is_parcel,
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
