<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Example: Only the user who placed the order or an admin can update
        // return $this->route('order')->user_id === $this->user()->id || $this->user()->isAdmin();
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['sometimes', 'nullable', 'exists:users,id'],
            'total_price' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['sometimes', 'string'], // Consider specific statuses
            'items' => ['sometimes', 'array', 'min:1'], // Array of order items for potential update/replacement
            'items.*.product_id' => ['sometimes', 'exists:products,id'],
            'items.*.quantity' => ['sometimes', 'integer', 'min:1'],
            'items.*.price' => ['sometimes', 'numeric', 'min:0'],
        ];
    }
}
