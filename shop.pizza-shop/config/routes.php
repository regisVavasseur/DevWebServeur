<?php
declare(strict_types=1);

use pizzashop\shop\app\action\AuthRefresh;
use pizzashop\shop\app\action\AuthSignin;
use pizzashop\shop\app\action\AuthValidate;
use pizzashop\shop\app\action\GetCommandeAction;
use pizzashop\shop\app\action\GetProduitByNumeroAction;
use pizzashop\shop\app\action\GetProduitsAction;
use pizzashop\shop\app\action\GetProduitsByCategAction;
use pizzashop\shop\app\action\PatchValiderCommandeAction;
use pizzashop\shop\app\action\PostCreerCommandeAction;
use Slim\App;


return function( App $app):void {

    $app->options('/{routes:.+}', function ($request, $response) {
        return $response;
    });

    $app->post('/commandes[/]', PostCreerCommandeAction::class)->setName('creer_commande');

    $app->patch('/commandes/{id_commande}[/]', PatchValiderCommandeAction::class)->setName('patch_commandes');

    $app->get('/commandes/{id}[/]', GetCommandeAction::class)->setName('commandes');

    $app->post('/signin[/]', AuthSignin::class)->setName('signin');

    $app->get('/validate[/]', AuthValidate::class)->setName('validate');

    $app->get('/refresh[/]', AuthRefresh::class)->setName('refresh');

    $app->get('/produits[/]', GetProduitsAction::class)->setName('produits');

    $app->get('/produit/{id}[/]', GetProduitByNumeroAction::class)->setName('produit');

    $app->get('/categories/{id_categorie}/produits[/]', GetProduitsByCategAction::class)->setName('produits_by_categ');
};