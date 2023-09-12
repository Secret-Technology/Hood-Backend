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
            'id'                    => $this->id,
            'status'                => $this->status,
            'distance'              => (float) $this->distance,
            'time'                  => (float) $this->time,
            'payment_type'          => $this->payment_type,
            'note'                  => $this->note,
            'fare_price'            => (float) $this->fare_price,
            'user_fare_price'       => (float) $this->user_fare_price,
            'accepted_fare_price'   => (float) $this->accepted_fare_price,
            'driver_fare'           => (float) $this->driver_fare,
            'tip'                   => (float) $this->tip,
            'from'                  => @$this->address->from,
            'to'                    => @$this->address->to,
            'extra_routes'          => @$this->address->extra_routes,
            'google_route'          => $this->google_route,
            'is_parcel'             => (bool) @$this->package->is_parcel,
            'parcel_details'        => $this->details ? ParcelDetailsResource::make($this->details) : null,
            'created_at'            => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
