<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $fillable = ["name", "damage", "health", "armor"];
    /** @use HasFactory<\Database\Factories\HeroFactory> */
    use HasFactory;
}
