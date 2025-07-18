<?php

namespace App\Http\Requests\Discount;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDiscountRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'product_id' => ['sometimes', 'nullable', 'exists:products,id'],
            'discount_type' => ['sometimes', 'string', Rule::in(['percentage', 'fixed'])],
            'value' => ['sometimes', 'numeric', 'min:0'],
            'start_date' => ['sometimes', 'date', 'after_or_equal:today'],
            'end_date' => ['sometimes', 'date', 'after_or_equal:start_date'],
        ];
    }
}
