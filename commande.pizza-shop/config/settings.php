<?php

use Monolog\Level;

return [
    'logger.file' => __DIR__ . '/../../../logs/errors.log',
    'logger.level' => Level::Error,
    'connection.name.catalogue' => 'catalog',
    'connection.name.commande' => 'commande',
    'uri.auth' => 'http://auth.pizza-shop.local',
    'uri.catalogue' => 'http://api.pizza-shop.catalog',
];