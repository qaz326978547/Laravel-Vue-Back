<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Cart;
use App\Http\Models\Products;
use Illuminate\Support\Facades\Validator;

class CartItemController extends Controller
{





    // public function getCartItems()
    // {
    //     $user = auth()->user(); //取得使用者資料
    //     $cart = Cart::where('user_id', $user->id)->first(); //取得購物車
    //     $cartItems = $cart->cartItems()->with('product')->get(); //取得購物車內容
    //     return response()->json([
    //         'cartItems' => $cartItems
    //     ], 200);
    // }
    public function updateCartItem(Request $request) //$request要傳入 product_id,quantity
    {
        $form = $request->all();
        $rules = [
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|between:1,100',
        ];
        $message = [
            'product_id.required' => '請輸入商品ID',
            'product_id.integer' => '商品ID必須為數字',
            'quantity.required' => '請輸入商品數量',
            'quantity.integer' => '商品數量必須為數字',
            'quantity.between' => '商品數量必須介於1~100之間',
        ];
        $validator = Validator::make($form, $rules, $message);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 400);
        }
        //看商品庫存是否足夠
        $product = Products::findOrFail($request->product_id); //取得商品 findOrFail:找不到會回傳404
        if ($product->quantity < $request->quantity) { //如果商品庫存小於要求數量
            return response()->json([
                'message' => '商品庫存不足',
            ], 400);
        }
        $product->quantity -= $request->quantity; //商品庫存減少
        $product->save();
        // 

        $user = auth()->user(); //取得使用者資料
        $cart = Cart::find($user->id); //取得購物車
        //如果沒有購物車 新增購物車
        if (!$cart) {
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->save();
        }
        //如果購物車內有相同的商品 更新數量
        $cart = Cart::firstOrNew(['user_id' => $user->id]); //取得購物車
        $cart->save();
        $cartItem = $cart->cartItems()->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            return response()->json([
                'message' => '更新成功',
                'cartItem' => $cartItem
            ], 200);
        } else {
            //如果沒有相同的商品 新增商品
            $cartItem = $cart->cartItems()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
            return response()->json([
                'message' => '新增成功',
                'cartItem' => $cartItem
            ], 201);
        }
    }
    public function deleteCartItem(Request $request) //$request要傳入product_id
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
