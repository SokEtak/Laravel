<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'exists:users,id'], // Can be for a guest or a logged-in user
            'total_price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string'], // Consider specific statuses like Rule::in(['pending', 'processing', 'shipped', 'delivered', 'cancelled'])
            'items' => ['required', 'array', 'min:1'], // Array of order items
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
