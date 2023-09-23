<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\CheckForMaintenanceMode::class, //這是檢查維護模式的，如果你的session有用到維護模式的話，可以加上這個
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class, //這是驗證post size的，如果你的session有用到post的話，可以加上這個
        \App\Http\Middleware\TrimStrings::class, //這是把字串前後空白去掉的，如果你的session有用到字串的話，可以加上這個
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class, //這是把空字串轉成null的，如果你的session有用到空字串的話，可以加上這個
        \App\Http\Middleware\TrustProxies::class, //這是信任代理的，如果你的session有用到代理的話，可以加上這個
        \Fruitcake\Cors\HandleCors::class,



    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class, //這是加密cookie的，如果你的session有用到cookie的話，可以加上這個
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class, //這是把cookie加到response的，如果你的session有用到cookie的話，可以加上這個
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class, //這是認證session的，如果你的session有認證的話，可以加上這個
            \Illuminate\View\Middleware\ShareErrorsFromSession::class, //這是把session的error加到view的，如果你的session有error的話，可以加上這個
            \App\Http\Middleware\VerifyCsrfToken::class, //這是驗證csrf的，如果你的session有csrf的話，可以加上這個
            \Illuminate\Routing\Middleware\SubstituteBindings::class, //這是替換綁定的，如果你的session有綁定的話，可以加上這個
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [

        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'checkRole' => \App\Http\Middleware\CheckRole::class, //這是檢查角色的，如果你的session有用到角色的話，可以加上這個
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'check.token' => \App\Http\Middleware\CheckTokenMiddleware::class,
    ];
}
