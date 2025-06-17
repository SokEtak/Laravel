<?php

namespace App\Http\Requests\orders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateOrderDetailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // The rules are identical to your store request
        return array_merge($this->commonItemValidationRules(), [
            'user_id' => 'required|integer|exists:users,id',
            'provider' => 'required|string|in:cash,bank',
            'status' => 'required|string|in:paid,unpaid,pending',
            'bank_detail' => 'nullable|string|max:255|required_if:provider,bank',
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation Error',
            'errors' => $validator->errors()
        ], 422)); // This is where the 422 should be returned
    }

    public function messages(): array
    {
        return [
            'items.required' => 'At least one item is required.',
            'items.array' => 'Items must be an array.',
            'items.min' => 'At least one item is required.',
            'items.*.product_id.required' => 'Product ID is required for each item.',
            'items.*.product_id.integer' => 'Product ID must be an integer.',
            'items.*.product_id.exists' => 'The selected product ID does not exist.',
            'items.*.quantity.required' => 'Quantity is required for each item.',
            'items.*.quantity.integer' => 'Quantity must be an integer.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
            'user_id.required' => 'User ID is required.',
            'user_id.integer' => 'User ID must be an integer.',
            'user_id.exists' => 'The selected user ID does not exist.',
            'provider.required' => 'Payment provider is required.',
            'provider.string' => 'Payment provider must be a string.',
            'provider.in' => 'Selected payment provider is invalid. Must be cash or bank.',
            'status.required' => 'Payment status is required.',
            'status.string' => 'Payment status must be a string.',
            'status.in' => 'Selected payment status is invalid. Must be paid, unpaid, or pending.',
            'bank_detail.max' => 'Bank detail may not be greater than 255 characters.',
            'bank_detail.required_if' => 'Bank detail is required when the provider is bank.',
        ];
    }

    /**
     * Common validation rules for items.
     *
     * @return array
     */
    private function commonItemValidationRules(): array
    {
        return [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }
}
