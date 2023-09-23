<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $table = 'cart';
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];
    public function cartItems()
    {
        //hasMany(關聯模型,外鍵,主鍵) 一對多
        return $this->hasMany(CartItems::class, 'cart_id', 'id'); //cart_id是CartItem的欄位，id是Cart的欄位 與cartItem關聯 多對一
    }
    public function user()
    {
        //belongsTo(關聯模型,外鍵,主鍵) 一對多
        return $this->belongsTo(User::class, 'user_id', 'id'); //user_id是Cart的欄位，id是User的欄位 與User關聯 多對一
    }
}
