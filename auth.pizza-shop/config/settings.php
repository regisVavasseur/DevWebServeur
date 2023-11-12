<?php

return [
    'settings' => [
        'displayErrorDetails' => true, // Should be set to false in production
        // Database connection settings
        "db" => [
            "host" => "pizza-shop.auth.db",
            "database" => "pizza_shop",
            "username" => "pizza_shop",
            "password" => "pizza_shop",
            "driver" => "mysql",
        ],
        // JWT settings
        "jwt" => [
            'secret' => 'jwt_secret',
            'expires' => 3600,
            'issuer' => 'pizza-shop.auth',
        ],
    ],
];