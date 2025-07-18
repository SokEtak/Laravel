<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreScheduleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $isSuperAdmin = Auth::check() && Auth::user()->role_id !== 1;

        $rules = [
            'course_id' => ['required', 'exists:courses,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'day_of_week' => ['required', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
        ];

        if ($isSuperAdmin) {
            $rules['tenant_id'] = ['required', 'integer', 'exists:tenants,id'];
        }

        return $rules;
    }
}
