<?php

return [
    'paths' => [
        'login',
        'logout',
        'sanctum/csrf-cookie',
        'api/*'
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://localhost:3000'],

    'allowed_headers' => ['*'],

    'supports_credentials' => true,
];

