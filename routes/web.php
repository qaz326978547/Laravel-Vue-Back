<?php

use App\Http\Controllers\CartItemController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () { //這邊意思是說，所有的api都要加上api這個前綴


    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::get('product', 'ProductsController@getProducts');
    Route::get('product/{id}', 'ProductsController@getProduct');
    Route::middleware(['auth:api', 'check.token'])->group(function () { //前端如果要判斷是否登入可以用這個middleware
        Route::get('cart', 'CartController@getCart'); //這邊的cart是指/api/cart 取得購物車
        Route::post('cart/add', 'CartItemController@updateCartItem');
        Route::get('init', 'AuthController@init'); //這邊的init是指/api/init 取得使用者資料
        Route::post('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::post('cart/delete', 'CartItemController@deleteCartItem');
        Route::prefix('admin')->middleware('checkRole')->group(function () { //加上middleware('checkRole')，代表這個路由群組裡面的路由都要經過checkRole這個middleware
            //這邊先經過是否登入的middleware，再經過checkRole這個middleware，最後才會到controller
            Route::post('product/add', 'ProductsController@addProduct');
            Route::post('product/{id}/update', 'ProductsController@updateProduct');
        });
    });
});
