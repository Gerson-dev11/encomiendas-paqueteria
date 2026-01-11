<?php

return [

    /*

    |--------------------------------------------------------------------------

    | Laravel CORS Configuration

    |--------------------------------------------------------------------------

    |

    | Esta configuración controla los encabezados CORS para tus rutas de API.

    | Necesitamos habilitar credenciales (cookies) y permitir el dominio del

    | frontend (Vite: localhost:5173) y el dominio de producción.

    |

    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://encomiendasmaxexpress.netlify.app',
        'http://localhost:5173',
        'https://max-expressv1.onrender.com',
    ],
    'supports_credentials' => true,

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

];
