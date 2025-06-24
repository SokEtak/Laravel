<?php

namespace App\Http\Requests\orderItems;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'order_id' => 'required|exists:order_details,id',
            'product_id' => 'required|numeric|min:0',
            'quantity' => 'required|string',
            'price' => 'required|in:paid,unpaid,pending',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'order_id.required' => 'The order ID is required.',
            'order_id.exists' => 'The selected order ID does not exist.',
            'product_id.required' => 'The product ID is required.',
            'product_id.numeric' => 'The product ID must be a number.',
            'product_id.min' => 'The product ID must be at least 0.',
            'quantity.required' => 'The quantity is required.',
            'quantity.string' => 'The quantity must be a string.',
            'price.required' => 'The price is required.',
            'price.in' => 'The price status must be one of the following: paid, unpaid, pending.',
        ];
    }
}
