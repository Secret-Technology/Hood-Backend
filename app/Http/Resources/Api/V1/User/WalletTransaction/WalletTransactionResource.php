<?php

namespace App\Http\Resources\Api\V1\User\WalletTransaction;

use App\Http\Resources\Api\Helper\ProviderSimpleResource;
use App\Http\Resources\Api\Helper\UserSimpleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'order'             => $this->order ? [
                'id'            => $this->order->id,
                'status'        => $this->order->status,
                'transaction_id'=> $this->order->transaction_id,
            ] : null,
            'amount'            => round((float)$this->amount),
            'wallet_before'     => round((float)$this->wallet_before),
            'wallet_after'      => round((float)$this->wallet_after),
            'transaction_type'  => $this->transaction_type,
            'created_at'        => $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null,
        ];
    }
}
