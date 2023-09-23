<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;
use Carbon\Carbon;
use Closure;

class CheckTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('api')->check()) { // guard('api') 這裡的 api 是 config/auth.php 裡面的 api  guard
            $user = Auth::guard('api')->user();
            //在$user內加入使用者當前token
            $user->token = $request->bearerToken();
            //在$user內加入使用者當前token的到期時間
            $user->token_expires_at = Token::find($user->token()->id)->expires_at->toDateTimeString();
            $request->attributes->add(['user' => $user]); //attributes->add() 這個方法可以在 Request 物件中加入屬性
        } else {
            // Token 未验证通过
            // 返回未授权的响应
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
