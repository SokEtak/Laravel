<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    protected $fillable = ["category_name","category_description"];
    /** @use HasFactory<\Database\Factories\ProductCategoryFactory> */
    use HasFactory;

    function products(){
        return $this->hasMany(Product::class,'category_id');
    }

    function product_inventory(){
        return $this->hasMany(ProductInventory::class);
    }
}
