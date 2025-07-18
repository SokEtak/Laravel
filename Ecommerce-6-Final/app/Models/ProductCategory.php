<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = ["category_id","product_id"];

    public $timestamps = false; //remove timestamp
}
