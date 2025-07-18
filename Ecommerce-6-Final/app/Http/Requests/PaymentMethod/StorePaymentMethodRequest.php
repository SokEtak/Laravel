<?php

namespace App\Http\Requests\PaymentMethod;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentMethodRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'], // Must be associated with a user
            'type' => ['required', 'string', 'max:255'],
            'provider' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'], // Consider specific formats/lengths
            'expiry_date' => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }
}
