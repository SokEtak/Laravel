<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool { return true; } // User must be authenticated

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'user_id' => ['required', 'exists:users,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
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
