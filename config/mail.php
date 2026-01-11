<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mailer por defecto
    |--------------------------------------------------------------------------
    |
    | Se puede usar 'log' para pruebas locales o 'sendgrid' para envíos reales.
    |
    */
    'default' => env('MAIL_MAILER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Configuración de mailers
    |--------------------------------------------------------------------------
    */
    'mailers' => [
        'log' => [
            'transport' => 'log',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => '/usr/sbin/sendmail -bs',
        ],

        'sendgrid' => [
            'transport' => 'sendgrid',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dirección y nombre por defecto del remitente
    |--------------------------------------------------------------------------
    */
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'francogerson28@gmail.com'),
        'name' => env('MAIL_FROM_NAME', 'MAX EXPRESS'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Configuración específica de SendGrid
    |--------------------------------------------------------------------------
    */
    'sendgrid' => [
        'key' => env('SENDGRID_API_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Opciones de Markdown
    |--------------------------------------------------------------------------
    */
    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
