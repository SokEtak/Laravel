<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
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
            "first_name" => ["sometimes"],
            "last_name" => ["sometimes"],
            "gender" => ["sometimes", "in:male,female"],
            "dob" => ["sometimes", "date"],
            "hire_date" => ["sometimes"],
            "tenant_id" => ["sometimes"],
            "address" => ["nullable"],
        ];
    }
}
