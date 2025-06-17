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
            'product_name'=>$this->product_name,
            'product_description'=>$this->product_description,
            'SKU'=>$this->SKU,
            'price'=>$this->price,
            'discount_id'=>$this->discount_id,//prefer only id(not related data model)
            'discount'=>new DiscountResource($this->whenLoaded('discount')),
            'category'=>new CategoryResource($this->whenLoaded('category')),
            'inventory'=>new InventoryResource($this->whenLoaded('inventory')),
        ];
    }
}
//        'id' => $this->id,
//        'product_name' => $this->product_name,
//        'product_description' => $this->product_description,
//        'SKU' => $this->SKU,
//        'price' => $this->price,
//        'discount_id' => $this->discount_id,
//
//        // Include related data if loaded
//        'discount' => $this->whenLoaded('discount', function () {
//        return [
//            'discount_name' => $this->discount->discount_name,
//            'discount_description' => $this->discount->discount_description,
//            'discount_percent' => $this->discount->discount_percent,
//            'active' => $this->discount->active,
//        ];
//    }),
//        'category_id' => $this->category_id,
//        'inventory_id' => $this->inventory_id,
//    }
