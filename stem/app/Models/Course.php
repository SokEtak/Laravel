<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'schedule_id',
        'tenant_id',
        'teacher_id',
        'subject_id',
        'name',
        'description',
        'level',
    ];



    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function enrollments(){
        return $this->hasMany(Enrollment::class);
    }

    public function schedule(): BelongsTo{
        return $this->belongsTo(Schedule::class);
    }
}
