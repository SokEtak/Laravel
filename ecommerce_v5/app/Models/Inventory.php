<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Add HasFactory for factories

class Inventory extends Model
{
    use HasFactory; // Use HasFactory trait

    protected $fillable = ["quantity", "product_id"]; // Add product_id to fillable

    protected $table = 'inventories';

    // An inventory record belongs to a product.
    // The foreign key 'product_id' should exist on the 'inventories' table.
    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
