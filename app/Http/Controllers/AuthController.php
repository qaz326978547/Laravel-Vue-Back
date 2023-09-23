<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateUser;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

class AuthController extends Controller
{
    //
    public function signup(CreateUser $request)
    {

        $validated = $request->validated();
        $user = new User([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password'])
        ]);
        $user->save();
        return response()->json([
            'message' => '註冊成功'
        ], 201);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'string|required|email',
            'password' => 'string|required',
        ]);
        if (!Auth::attempt($validated)) {
            return response()->json([
                'message' => '登入失敗'
            ], 401);
        }
        $user = $request->user(); //取得使用者資料
        $tokenResult = $user->createToken('Token');
        $token = $tokenResult->token;
        $token->save();
        //在$user 裡面加入token
        $user->token = $tokenResult->accessToken;

        //在$user 裡面加入token到期時間 1天

        //如果到期時間設為一天
        // $user->token_expires_at = Token::find($user->token()->id)->expires_at->addDay()->toDateTimeString();
        return response()->json([
            'message' => '登入成功',
            'user' => $user
        ], 200);
    }
    public function init(Request $request)
    {

        $user = $request->attributes->get('user');
        if ($user) {
            return response()->json([
                'user' => $user
            ], 200);
        }
    }
    public function logout(Request $request)
    {
        //timestamp
        $request->input('timestamp'); //取得請求的timestamp
        $request->user()->token()->revoke();
        return response()->json([
            'message' => '登出成功'
        ], 200);
    }

    public function user(Request $request) //Request 是當前請求的物件 如果是get請求，就是取得當前登入使用者資料
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => '未登入'
            ], 401);
        }

        $user = $request->attributes->get('user');
        if (isset($user->token_expires_at)) { //如果有token_expires_at屬性
            $user->token_expires_at = Token::find($user->token()->id)->expires_at->toDateTimeString(); //取得token_expires_at屬性
            if (strtotime($user->token_expires_at) < strtotime('now')) { //如果token過期
                return response()->json([
                    'message' => 'token過期'
                ], 401);
            }
        }
        return response()->json([
            'user' => $user
        ], 200);
    }
}
