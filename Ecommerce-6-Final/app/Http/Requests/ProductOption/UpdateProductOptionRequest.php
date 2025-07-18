<?php

namespace App\Http\Requests\ProductOption;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductOptionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $productOptionId = $this->route('product_option')->id ?? null;

        // When updating, you generally don't change the product_id or the name/value
        // that form the unique constraint, unless you are replacing the option entirely.
        // If you allow changing option_name/option_value, you'd need a complex unique rule or
        // handle the uniqueness logic in your controller after update.
        return [
            'option_name' => ['sometimes', 'string', 'max:255'],
            'option_value' => ['sometimes', 'string', 'max:255'],
            // If product_id could change, ensure it exists: 'product_id' => ['sometimes', 'exists:products,id'],
        ];
    }
}
