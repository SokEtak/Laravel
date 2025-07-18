<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool { return true; } // Usually admin-only

    public function rules(): array
    {
        $roleId = $this->route('role')->id ?? null;

        return [
            'name' => ['sometimes', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($roleId)],
            'permission_ids' => ['sometimes', 'array'], // For attaching permissions
            'permission_ids.*' => ['exists:permissions,id'],
        ];
    }
}
