<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    //
    protected $table = 'cart_items';
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];
    public function product()
    {
        //belongsTo(關聯模型,外鍵,主鍵) 一對多
        return $this->belongsTo(Products::class, 'product_id', 'id'); //product_id是CartItem的欄位，id是Products的欄位 與Products關聯 多對一
    }

    public function cart()
    {
        //belongsTo(關聯模型,外鍵,主鍵) 一對多
        return $this->belongsTo(Cart::class, 'cart_id', 'id'); //cart_id是CartItem的欄位，id是Cart的欄位 與Cart關聯 多對一
    }
}
