<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
            "first_name", "last_name", "gender", "dob", "address", "hire_date", "tenant_id", "subject_id"
    ];

    /**
     * The accessors to append to the model's array form.
     * This is essential for 'full_name' to be included when the model is converted to JSON/array.
     *
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * Get the teacher's full name.
     * This is the accessor that combines first and last name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        // Ensure that first_name and last_name are not null before concatenating
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }

    // Teacher belongs to one subject
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id', 'id');
    }
}
