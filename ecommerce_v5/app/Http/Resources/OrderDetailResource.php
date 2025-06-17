<?php

namespace App\Http\Resources;

use App\Models\PaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'total' => $this->total,
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'payment' => new PaymentDetailResource($this->whenLoaded('paymentDetail')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
