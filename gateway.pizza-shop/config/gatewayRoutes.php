<?php

use pizzashop\gateway\app\action\CatalogueAction;
use pizzashop\gateway\app\action\CommandeAction;
use pizzashop\gateway\app\action\UserAction;
use Slim\App;

return function(App $app) {
    $app->group('/api/', function($app) {
        $app->group('users', function($app) {
            $app->post('/signin[/]', UserAction::class);
            $app->get('/validate[/]', UserAction::class);
            $app->post('/refresh[/]', UserAction::class);
            $app->post('/signup[/]', UserAction::class);
        });

        $app->group('commandes', function($app) {
            $app->post('[/]', CommandeAction::class);
            $app->patch('/{id_commande}[/]', CommandeAction::class);
            $app->get('/{id}[/]', CommandeAction::class);
        });

        $app->group('produits', function($app) {
            $app->get('[/filter/{filtering}[/]]', CatalogueAction::class);
            $app->get('/{id}[/]', CatalogueAction::class);
            $app->get('/categorie/{id_categorie}[/]', CatalogueAction::class);
        });
    });
};