<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "product_name",
        "product_description",
        "SKU",
        "discount_id",
        "category_id",
        "price",
        "inventory_id" // Ensure this is in fillable if you want to assign it directly
    ];

    use HasFactory;

    // Relationship functions
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id','id');
    }

    function discount(){
        return $this->belongsTo(Discount::class, 'discount_id', 'id');
    }

    // A product has one inventory record, and the foreign key 'inventory_id' is on the products table.
    public function inventory(){
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }
}
