<?php

namespace App\Http\Resources\Api\V1\User\Package;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            'name' => $this->name,
            'img' => $this->img,
            'km_price' => (float) $this->km_price,
            'is_parcel' => (bool) $this->is_parcel,
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
