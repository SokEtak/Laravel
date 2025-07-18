<?php

namespace App\Http\Requests\ProductView;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductViewRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        // Product views are typically just recorded, not updated.
        // This request class is likely redundant unless new attributes are added.
        return [];
    }
}
