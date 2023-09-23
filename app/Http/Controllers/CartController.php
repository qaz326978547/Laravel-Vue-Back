<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Cart;
use App\Http\Models\CartItems;

class CartController extends Controller
{
    public function getCart()
    {
        $user = auth()->user(); // 获取用户数据
        $cart = Cart::where('user_id', $user->id)->first(); // 获取购物车

        // 如果没有购物车，创建一个
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $user->id,
            ]);
        }

        $cartItems = $cart->cartItems()->get(); // 获取购物车内容

        // 如果购物车内没有商品
        if (!$cartItems) {
            return response()->json([
                'message' => '購物車內沒有商品',
            ], 400);
        }

        // 计算购物车内所有商品的总数量和总金额
        $totalQuantity = 0;
        $totalAmount = 0;

        foreach ($cartItems as $cartItem) {

            $totalQuantity += $cartItem->quantity;
            $totalAmount += $cartItem->quantity * $cartItem->product->price;
        }
        $products = [];
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            $products[] = [
                'product_id' => $product->id, // 商品 ID
                'title' => $product->title, // 商品标题
                'image' => $product->image, // 商品图片
                'price' => $product->price, // 商品价格
                'quantity' => $cartItem->quantity, // 购买数量
            ];
        }
        // 构建响应结构，包括购物车的总数量和总金额
        $response = [
            'cart_id' => $cart->id, // 这里使用购物车的 ID
            'user_id' => $cart->user_id, // 用户 ID
            'quantity' => $totalQuantity,
            'total' => $totalAmount,
            'products' =>  $products, // 购物车内的商品
        ];

        return response()->json($response, 200);
    }
    public function addCart(Request $request) //$request要傳入 product_id,quantity
    {
        $user = auth()->user(); //取得使用者資料
        $cart = Cart::where('user_id', $user->id)->first(); //取得購物車
        if (!$cart) { //如果沒有購物車
            $cart = Cart::create([
                'user_id' => $user->id,
            ]);
        }
        $cartItem = $cart->cartItems()->where('product_id', $request->product_id)->first(); //取得購物車內容
        if ($cartItem) { //如果購物車內有商品
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else { //如果購物車內沒有商品
            $cartItem = $cart->cartItems()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }
        return response()->json([
            'message' => '新增成功',
        ], 200);
    }

    public function deleteCartItem(Request $request) //$request要傳入 product_id
    {
        $user = auth()->user(); //取得使用者資料
        $cart = Cart::where('user_id', $user->id)->first(); //取得購物車
        $cartItem = $cart->cartItems()->where('product_id', $request->product_id)->first(); //取得購物車內容
        $cartItem->delete();
        return response()->json([
            'message' => '刪除成功',
        ], 200);
    }
}
