<?php

namespace App\Http\Resources\Api\V1\User\ParcelCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParcelCategoryResource extends JsonResource
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
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
