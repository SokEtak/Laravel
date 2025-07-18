<?php

namespace App\Http\Requests\CartItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCartItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Example: User can only add items to their own cart session
        // return $this->route('cart_session')->user_id === $this->user()->id;
        return true;
    }

    public function rules(): array
    {
        return [
            'cart_session_id' => ['required', 'exists:cart_sessions,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    // You might want a custom validation rule to ensure unique cart_session_id and product_id combination
    // Or handle this logic in your controller/service
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('cart_session_id') && $this->has('product_id')) {
                $exists = \App\Models\CartItem::where('cart_session_id', $this->cart_session_id)
                    ->where('product_id', $this->product_id)
                    ->exists();
                if ($exists) {
                    $validator->errors()->add('product_id', 'This product already exists in the cart for this session. Please update the quantity.');
                }
            }
        });
    }
}
