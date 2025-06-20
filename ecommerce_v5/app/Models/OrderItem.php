<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ["order_id", "product_id", "quantity","price"];

    public function order()
    {
        return $this->belongsTo(OrderDetail::class, 'order_id','id');
    }

    function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
