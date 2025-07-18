<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = ['tenant_id','student_id','course_id','fee'];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function tenant(){
        return $this->belongsTo(Tenant::class);
    }

}
