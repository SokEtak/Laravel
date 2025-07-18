<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    public function teacher(){
        return $this->hasMany(Teacher::class,"tenant_id",'id');
    }

    public function student(){
        return $this->hasMany(Student::class,"tenant_id",'id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

}
