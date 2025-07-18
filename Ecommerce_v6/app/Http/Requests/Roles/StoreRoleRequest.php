<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool { return true; } // Usually admin-only

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permission_ids' => ['sometimes', 'array'], // For attaching permissions
            'permission_ids.*' => ['exists:permissions,id'],
        ];
    }
}
