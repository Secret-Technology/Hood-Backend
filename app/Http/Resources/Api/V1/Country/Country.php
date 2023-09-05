<?php

namespace App\Http\Resources\Api\V1\Country;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Country extends JsonResource
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
            'phone_code' => $this->phone_code,
            'code' => $this->code,
            'img' => $this->img,
            'currency_name' => $this->currency_name,
            'currency_symbol' => $this->currency_symbol,
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
