<?php

namespace App\Http\Requests\OrderItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderItemRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        // For updating a specific order item, usually only quantity and/or price are changeable.
        return [
            'quantity' => ['sometimes', 'integer', 'min:1'],
            'price' => ['sometimes', 'numeric', 'min:0'],
        ];
    }
}
