<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEnrollmentRequest extends FormRequest
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
        $isSuperAdmin = Auth::check() && Auth::user()->role_id !== 1 ;

        $rules = [
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'fee' => 'required|numeric|min:0',
        ];

        if ($isSuperAdmin) {
            $rules['tenant_id'] = 'required|exists:tenants,id';
        }

        return $rules;
    }
}
