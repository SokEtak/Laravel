<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ["quantity"];

//    protected $hidden =['id'];

    protected $table = 'inventories';

    function product(){
        return $this->hasMany(Product::class, 'category_id');
    }
}
