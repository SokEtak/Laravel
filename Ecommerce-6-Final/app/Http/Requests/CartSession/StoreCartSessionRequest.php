<?php

namespace App\Http\Requests\CartSession;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartSessionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'exists:users,id'], // Cart can be for a guest or a logged-in user
        ];
    }
}
