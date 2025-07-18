<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }

        // Get the student being updated from the route parameters
        $student = $this->route('student');

        // A Super Admin can update any student.
        if ($user->role_id !== 1) { // Assuming role_id != 1 is Super Admin
            return true;
        }

        // A Normal Admin (role_id = 1) can only update students within their own tenant.
        return $student && $student->tenant_id === $user->tenant_id;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        $rules = [
            "first_name" => ["required", "string", "max:255"],
            "last_name" => ["required", "string", "max:255"],
            "gender" => ["required", Rule::in(['male', 'female'])],
            "dob" => ["required", "date"],
            "grade" => ["required", "string", "max:255"],
            "address" => ["nullable", "string", "max:1000"],
        ];

        // Super Admins can update the tenant_id of a student.
        if (!$isNormalAdmin) {
            $rules['tenant_id'] = ['required', 'exists:tenants,id'];
        }

        return $rules;
    }
}
