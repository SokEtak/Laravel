<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'payment_method_id' => ['nullable', 'exists:payment_methods,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string'], // e.g., Rule::in(['pending', 'completed', 'failed', 'refunded'])
        ];
    }
}
