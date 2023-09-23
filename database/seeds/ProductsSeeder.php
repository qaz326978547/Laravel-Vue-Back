<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Products;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Products::upsert([ //upsert是指如果資料庫中有資料就更新，沒有就新增
            ['title' => 'iPhone 7', 'description' => 'iPhone 7 128G', 'price' => 25000, 'image' => 'https://www.techexchange.co.za/wp-content/uploads/2021/07/Apple-iPhone-7-Gold-Apple-iPhone-7-128GB-Gold-CPO.png', 'quantity' => 10],
            ['title' => 'iPhone 8', 'description' => 'iPhone 8 128G', 'price' => 30000, 'image' => 'https://www.computervillageonline.com/wp-content/uploads/2021/02/refurb-iphone8-spacegray.jpg', 'quantity' => 10],
            ['title' => 'iPhone X', 'description' => 'iPhone X 128G', 'price' => 35000, 'image' => 'https://frankmobile.com.au/cdn/shop/products/iphone-x-apple-phone-175777.jpg?v=1660884383', 'quantity' => 10],
            ['title' => 'iPhone 11', 'description' => 'iPhone 11 128G', 'price' => 40000, 'image' => 'https://s7d1.scene7.com/is/image/dish/2020-apple-iphone-11-black-front-back?$ProductBase$&fmt=webp', 'quantity' => 10],
            ['title' => 'iPhone 12', 'description' => 'iPhone 12 128G', 'price' => 45000, 'image' => 'https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/refurb-iphone-12-purple-2021?wid=2000&hei=1897&fmt=jpeg&qlt=95&.v=1635202738000', 'quantity' => 10],
        ], ['title', 'description', 'price', 'image', 'quantity']);
    }
}
