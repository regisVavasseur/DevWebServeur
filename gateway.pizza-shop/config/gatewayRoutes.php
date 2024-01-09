<?php

use pizzashop\gateway\app\action\CatalogueAction;
use pizzashop\gateway\app\action\CommandeAction;
use pizzashop\gateway\app\action\ProduitAction;
use pizzashop\gateway\app\action\UserAction;
use Slim\App;

return function(App $app) {
    $app->group('/api/', function($app) {
        $app->group('users', function($app) {
            $app->post('/signin', UserAction::class);
            $app->get('/validate', UserAction::class);
            $app->post('/refresh', UserAction::class);
            $app->post('/signup', UserAction::class);
        });

        $app->group('commandes', function($app) {
            $app->post('/creer', CommandeAction::class);
            $app->patch('/valider', CommandeAction::class);
            $app->get('/commande/{id}', CommandeAction::class);
        });

        $app->group('produits', function($app) {
            $app->get('[/{filtering}]', ProduitAction::class);
            $app->get('/{id}', ProduitAction::class);
            $app->get('/categories/{id_categorie}', ProduitAction::class);
        });

        $app->group('catalogue', function($app) {
            $app->get('[/{filtering}]', CatalogueAction::class);
            $app->get('/{id}', CatalogueAction::class);
            $app->get('/categories/{id_categorie}', CatalogueAction::class);
        });
    });
};