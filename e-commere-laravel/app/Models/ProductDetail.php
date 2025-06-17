<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected  $fillable = ["product_id", "name", "description"];
    /** @use HasFactory<\Database\Factories\ProductDetailFactory> */
    use HasFactory;

    function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
