<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Example: Only the review author or an admin can update
        // return $this->route('review')->user_id === $this->user()->id || $this->user()->isAdmin();
        return true;
    }

    public function rules(): array
    {
        return [
            'rating' => ['sometimes', 'integer', 'min:1', 'max:5'],
            'comment' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
