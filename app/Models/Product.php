<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'product';

    protected $fillable = [
        'code_product',
        'name',
        'quantity',
        'price',
        'img'
    ];

    public function product(){
        return $this->hasMany(\App\Models\OrderDetail::class);
    }
}
