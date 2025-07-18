<?php

namespace App\Http\Requests\ProductOption;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductOptionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'option_name' => ['required', 'string', 'max:255'],
            'option_value' => ['required', 'string', 'max:255'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('product_id') && $this->has('option_name') && $this->has('option_value')) {
                $exists = \App\Models\ProductOptions::where('product_id', $this->product_id)
                    ->where('option_name', $this->option_name)
                    ->where('option_value', $this->option_value)
                    ->exists();
                if ($exists) {
                    $validator->errors()->add('option_value', 'This product already has this option name and value combination.');
                }
            }
        });
    }
}
