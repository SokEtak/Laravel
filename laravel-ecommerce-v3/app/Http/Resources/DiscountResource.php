<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
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
            'discount_name'=>$this->discount_name,
            'discount_description'=>$this->discount_description,
            'discount_percent'=>$this->discount_percent,
            'active'=>$this->active,
        ];
    }
}
