<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = ["user_id","total"];

    function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
