<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "product_name",
        "product_description",
        "SKU","discount_id",
        "category_id",
        "price",
        "inventory_id"
    ];
//    protected $hidden = ['id'];

    use HasFactory;

    //relationship function
    public function category(){
        return $this->belongsTo(Category::class, 'category_id','id');
    }

    function discount(){
        return $this->belongsTo(Discount::class, 'discount_id', 'id');
    }

    function inventory(){
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }

}
