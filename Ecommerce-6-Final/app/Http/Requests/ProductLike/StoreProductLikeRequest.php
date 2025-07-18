<?php

namespace App\Http\Requests\ProductLike;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductLikeRequest extends FormRequest
{
    public function authorize(): bool { return true; } // User must be authenticated

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'user_id' => ['required', 'exists:users,id',
                Rule::unique('product_likes')->where(function ($query) {
                    return $query->where('product_id', $this->product_id);
                })
            ], // Ensures a user can only like a product once
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
