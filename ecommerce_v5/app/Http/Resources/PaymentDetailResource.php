<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentDetailResource extends JsonResource
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
            'order_id' => $this->order_id,
            'amount' => $this->amount,
            'provider' => $this->provider,
            'status' => $this->status,
            'bank_detail' => $this->bank_detail,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'order' => new OrderDetailResource($this->whenLoaded('order')),
        ];
    }
}
