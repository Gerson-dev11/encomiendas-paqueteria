<?php

namespace App\Infrastructure\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Middleware global de la aplicación.
     *
     * Se ejecuta en **todas** las peticiones HTTP.
     */
    protected $middleware = [
        \App\Infrastructure\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Infrastructure\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Infrastructure\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * Middleware de grupo.
     *
     * Por ejemplo, para API o web.
     */
    protected $middlewareGroups = [
        'web' => [
            // 🔒 vacío o comenta todo para evitar sesiones/redirecciones
            // \App\Http\Middleware\EncryptCookies::class,
            // \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            // \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Middleware asignable a rutas específicas.
     *
     * Aquí es donde definimos tu middleware para usarlo en rutas que quieras.
     */
protected $routeMiddleware = [
    // Middlewares de Laravel
    'auth' => \App\Infrastructure\Http\Middleware\Authenticate::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

    // Middlewares personalizados
    'global' => \App\Infrastructure\Http\Middleware\Globals\GlobalKeyMiddleware::class,
    'checkrole' => \App\Infrastructure\Http\Middleware\CheckRoleDB::class, // 👈 AÑADE ESTA LÍNEA
];



}
