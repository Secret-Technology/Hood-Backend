<?php

namespace App\Http\Resources\Api\V1\User\User;

use App\Http\Resources\Api\V1\Country\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'phone_code' => $this->phone_code,
            'phone' => $this->phone,
            'email' => $this->email,
            'img' => $this->img,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'address' => $this->address,
            'identity_no' => $this->identity_no,
            'is_active' => (boolean) $this->is_active,
            'is_banned' => (boolean) $this->is_banned,
            'is_data_completed' => (boolean) $this->is_data_completed,
            'rating' => (int) $this->rating,
            'lang' => $this->lang,
            'theme' => $this->theme,
            'country' => Country::make($this->country),
            'token' => $this->when($this->token, $this->token),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
