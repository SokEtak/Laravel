<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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

        // Only Super Admins are required to provide tenant_id via the form.
        // For Normal Admins, tenant_id will be assigned in the controller.
        if (!$isNormalAdmin) {
            $rules['tenant_id'] = ['required', 'exists:tenants,id'];
        }

        return $rules;
    }

    // REMOVED: The prepareForValidation method is removed here.
    // The tenant_id for Normal Admins will now be assigned directly in the controller.
}
