<?php

namespace App\Http\Requests\orders\orders\payments;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentDetailRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
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

}
