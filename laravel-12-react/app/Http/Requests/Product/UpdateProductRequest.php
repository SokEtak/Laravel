<?php

namespace App\Http\Requests\Product;

class StoreProductRequest extends \Illuminate\Foundation\Http\FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.1',
            'description' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'price.required' => 'The price field is required.',
            'description.required' => 'The description field cannot be blank.',
        ];
    }


}
