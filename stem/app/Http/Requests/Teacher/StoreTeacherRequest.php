<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeacherRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'dob' => 'required|date',
            'hire_date' => 'required|date',
            'address' => 'required|string|max:500',
            'tenant_id' => [
                'required',
                'integer',
                Rule::exists('tenants', 'id')
            ],
            'subject_id' => [
                'required',
                'integer',
                Rule::exists('subjects', 'id')
            ]
        ];
    }
}
