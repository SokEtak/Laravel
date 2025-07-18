<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'order_id' => ['sometimes', 'exists:orders,id'],
            'payment_method_id' => ['sometimes', 'nullable', 'exists:payment_methods,id'],
            'amount' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['sometimes', 'string'],
        ];
    }
}
