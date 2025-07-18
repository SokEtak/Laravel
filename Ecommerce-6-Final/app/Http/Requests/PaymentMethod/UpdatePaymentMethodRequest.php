<?php

namespace App\Http\Requests\PaymentMethod;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentMethodRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Example: User can only update their own payment methods
        // return $this->route('payment_method')->user_id === $this->user()->id;
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['sometimes', 'exists:users,id'],
            'type' => ['sometimes', 'string', 'max:255'],
            'provider' => ['sometimes', 'string', 'max:255'],
            'account_number' => ['sometimes', 'string', 'max:255'],
            'expiry_date' => ['sometimes', 'nullable', 'date', 'after_or_equal:today'],
        ];
    }
}
