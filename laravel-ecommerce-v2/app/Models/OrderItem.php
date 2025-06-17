<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ["order_id", "product_id", "quantity"];

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class, 'order_id');
    }

    function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
