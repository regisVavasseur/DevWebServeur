<?php

return [
    'settings' => [
        'displayErrorDetails' => true, // Should be set to false in production
        // Database connection settings
        // JWT settings
        "jwt" => [
            'secret' => 'jwt_secret',
            'expires' => 3600,
            'issuer' => 'pizza-shop.auth',
        ],
    ],
    "uri.commande" => "http://api.pizza-shop.commandes",
    "uri.catalogue" => "http://api.pizza-shop.catalog",
    "uri.auth" => "http://api.pizza-auth",
];