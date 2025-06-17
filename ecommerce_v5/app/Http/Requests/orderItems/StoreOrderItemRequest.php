<?php

namespace App\Http\Requests\orderItems;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'order_id' => 'required|exists:order_details,id',
            'amount' => 'required|numeric|min:0',
            'provider' => 'required|string',
            'status' => 'required|in:paid,unpaid,pending',
            'bank_detail' => 'nullable|string|required_if:provider,bank',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'order_id.required' => 'The order ID is required.',
            'order_id.exists' => 'The selected order ID does not exist.',
            'amount.required' => 'The amount is required.',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The amount must be at least 0.',
            'provider.required' => 'The payment provider is required.',
            'provider.string' => 'The payment provider must be a string.',
            'status.required' => 'The payment status is required.',
            'status.in' => 'The payment status must be one of the following: paid, unpaid, pending.',
            'bank_detail.required_if' => 'The bank detail is required when the provider is bank.',
            'bank_detail.string' => 'The bank detail must be a string.',
        ];
    }
}
