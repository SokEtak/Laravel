<?php

namespace App\Models;

use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    protected $fillable = ["order_id","amount","provider","status","bank_detail"];

    public function order(){
        return $this->belongsTo(OrderDetail::class,"order_id");
    }
}
