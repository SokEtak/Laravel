<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Schedule extends Model
{
    protected $fillable = ['start_date', 'end_date', 'end_time', 'end_time', 'day_of_week','tenant_id'];

    public function course()
    {
        return $this->hasOne(Course::class, 'id', 'course_id');
    }
}
