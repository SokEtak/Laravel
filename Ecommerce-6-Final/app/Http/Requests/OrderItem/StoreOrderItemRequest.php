<?php

namespace App\Http\Requests\OrderItem;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderItemRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('order_id') && $this->has('product_id')) {
                $exists = \App\Models\OrderItem::where('order_id', $this->order_id)
                    ->where('product_id', $this->product_id)
                    ->exists();
                if ($exists) {
                    $validator->errors()->add('product_id', 'This product already exists in this order.');
                }
            }
        });
    }
}
