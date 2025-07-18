<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $isSuperAdmin = Auth::check() && Auth::user()->role_id !== 1;

        $rules = [
            'schedule_id' => ['required','exists:schedules,id'],
            'teacher_id'  => ['required', 'exists:teachers,id'],
            'subject_id'  => ['required', 'exists:subjects,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'level' => ['required', 'in:123,go,iq,exp'],
        ];

        // Require tenant_id for super admins
        if ($isSuperAdmin) {
            $rules['tenant_id'] = ['required', 'integer', 'exists:tenants,id'];
        }

        return $rules;
    }
}
