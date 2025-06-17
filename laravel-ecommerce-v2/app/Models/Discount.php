<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable  = ["discount_name","discount_description","discount_percent","active"];
    protected $hidden = ['id']; function product(){
    return $this->hasMany(Product::class, 'category_id');
}


}
