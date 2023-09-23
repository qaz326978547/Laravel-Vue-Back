<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CheckRole
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
        $user = auth()->user(); //取得當前登入使用者資料
        if ($user->role !== 1) {
            return response()->json([
                'message' => '權限不足'
            ], 403);
        }
        return $next($request);
    }
}
