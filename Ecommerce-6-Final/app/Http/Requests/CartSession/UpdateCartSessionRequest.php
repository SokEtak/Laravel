<?php

namespace App\Http\Requests\CartSession;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartSessionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'user_id' => ['sometimes', 'nullable', 'exists:users,id'],
        ];
    }
}
