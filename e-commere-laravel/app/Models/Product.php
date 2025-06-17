<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model

{
    protected $fillable = ["SKU", "category_id", "discount_id", "price"];
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    function product_category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class,'category_id');
    }

    function product_detail():HasOne
    {
        return $this->hasOne(ProductDetail::class,'product_id');
    }
    function discount(): BelongsTo{
        return $this->belongsTo(Discount::class);
    }
}
