<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ["name","description","discount_percentage","active"];
    /** @use HasFactory<\Database\Factories\DiscountFactory> */
    use HasFactory;

    function products(){
        return $this->hasMany(Product::class);
    }
}
