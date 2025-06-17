<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'SKU'=>$this->SKU,
            'category_id'=>$this->category_id,
            'discount_id'=>$this->discount_id,
            'price'=>$this->price,
        ];
    }
}
