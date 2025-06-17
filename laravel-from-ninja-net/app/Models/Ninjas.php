<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ninjas extends Model
{
    protected $fillable = ["name","damage","skill","dojo_id"];
    /** @use HasFactory<\Database\Factories\NinjasFactory> */
    use HasFactory;

    public function dojo(){
        return $this->belongsTo(Dojo::class);
    }
}
