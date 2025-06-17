<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    protected $fillable = ["product_id", "quantity"];
    /** @use HasFactory<\Database\Factories\ProductInventoryFactory> */
    use HasFactory;
    protected $table = 'product_inventory';
}
