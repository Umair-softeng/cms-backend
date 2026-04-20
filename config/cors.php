<?php

return [
    'paths' => [
        'login',
        'logout',
        'sanctum/csrf-cookie',
        'api/*',
        'admin/*',
        'complaint/*'
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://localhost:3000', 'https://complains.mcq.gob.pk'],

    'allowed_headers' => ['*'],

    'supports_credentials' => true,
];

