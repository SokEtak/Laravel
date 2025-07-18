<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description', // Optional, if you have additional fields
    ];

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'subject_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'subject_id', 'id');
    }
}
