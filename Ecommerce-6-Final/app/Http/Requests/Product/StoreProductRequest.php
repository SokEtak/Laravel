<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string','max:255'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'discount_amount' => ['nullable', 'decimal', 'min:0'],
            'sku' => ['nullable', 'string', 'max:50','unique:products,sku'],
            'status' => ['nullable', 'in:draft,published'],
        ];
    }
}
