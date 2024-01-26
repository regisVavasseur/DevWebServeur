<?php
declare(strict_types=1);

use pizzashop\catalog\app\action\GetProduitByNumeroAction;
use pizzashop\catalog\app\action\GetProduitsAction;
use pizzashop\catalog\app\action\GetProduitsByCategAction;
use Slim\App;

return function( App $app):void {

    $app->options('/{routes:.+}', function ($request, $response) {
        return $response;
    });
    $app->group('/produits', function($app) {
        $app->get('[/filter/{filtering}[/]]', GetProduitsAction::class)->setName('produits');

        $app->get('/{id}[/]', GetProduitByNumeroAction::class)->setName('produit');

        $app->get('/categorie/{id_categorie}[/]', GetProduitsByCategAction::class)->setName('produits_by_categ');
    });
};