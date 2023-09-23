<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    protected $table = 'products';
    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'quantity',
    ];

    public function getProducts()
    {
        return $this->all();
    }
}
