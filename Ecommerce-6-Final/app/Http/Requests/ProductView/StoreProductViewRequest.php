<?php

namespace App\Http\Requests\ProductView;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductViewRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'user_id' => ['nullable', 'exists:users,id'], // Can be a guest view
        ];
    }
    // Optionally: Automatically set user_id to authenticated user's ID
    public function prepareForValidation()
    {
        if (auth()->check() && ! $this->has('user_id')) {
            $this->merge(['user_id' => auth()->id()]);
        }
    }
}
