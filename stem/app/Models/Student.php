<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
   protected $fillable = ["first_name","last_name","gender","grade","dob","address","tenant_id"];

   use HasFactory;

   public function tenant(){
       return $this->belongsTo(Tenant::class);
   }

   public function enrollment(){
       return $this->hasMany(Enrollment::class);
   }
}
