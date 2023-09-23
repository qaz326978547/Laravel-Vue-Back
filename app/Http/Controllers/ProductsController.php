<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Products;

class ProductsController extends Controller
{
    public function getProducts()
    {
        $products = new Products();
        return response()->json([
            'data' => $products->getProducts()
        ], 200);
    }
    public function getProduct($id)
    {
        $products = new Products();
        return response()->json([
            'data' => $products->find($id)
        ], 200);
    }
    public function addProduct(Request $request)
    {
        $product = $request->validate([
            'title' => 'string|required',
            'description' => 'string',
            'price' => 'integer',
            'image' => 'string',
            'quantity' => 'integer|required|max:100|min:1',
        ]);
        $products = new Products();
        $products->fill($product); //填充資料
        $products->save(); //儲存
        return response()->json([
            'message' => '新增成功',
            'data' => $products 
        ], 201);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = $request->validate([
            'title' => 'string',
            'description' => 'string',
            'price' => 'integer',
            'image' => 'string',
            'quantity' => 'integer|max:100|min:1',
        ]);
        //如果只收到一個欄位，就只更新一個欄位
        $products = new Products();
        $products = $products->find($id);
        $products->fill($product); //填充資料
        $products->save(); //儲存
        return response()->json([
            'message' => '更新成功',
            'products' => $products
        ], 201);
    }
}
