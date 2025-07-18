<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $isSuperAdmin = Auth::check() && Auth::user()->role_id !== 1;

        $rules = [
            'tenant_id' => 'required,exists:tenants,id',
            'course_id' => 'required,exists:courses,id',
            'teacher_id' => 'required,exists:users,id',
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'level' => ['required', 'in:123,go,iq,exp'],
        ];

        //require these fields if SuperAdmin
        if($isSuperAdmin){
            $rules['tenant_id'] = ['required', 'integer', 'exists:tenants,id'];

        }

        return $rules;
    }
}
