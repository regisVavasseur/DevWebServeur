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

    $app->get('/produits[/filter/{filtering}]', GetProduitsAction::class)->setName('produits');

    $app->get('/produits/{id}', GetProduitByNumeroAction::class)->setName('produit');

    $app->get('/categories/{id_categorie}/produits[/]', GetProduitsByCategAction::class)->setName('produits_by_categ');
};