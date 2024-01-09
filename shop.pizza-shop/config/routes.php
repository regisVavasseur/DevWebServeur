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
use pizzashop\shop\domain\middlewares\BeforeCheckJWT;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;


return function( App $app):void {

    $app->options('/{routes:.+}', function ($request, $response) {
        return $response;
    });

    $app->group('/commandes', function (RouteCollectorProxy $commandesGrp) use ($app) {

        $commandesGrp->post('[/]', PostCreerCommandeAction::class)->setName('creer_commande');

        $commandesGrp->patch('/{id_commande}[/]', PatchValiderCommandeAction::class)->setName('patch_commandes');

        $commandesGrp->get('/{id}[/]', GetCommandeAction::class)->setName('commandes');

    })->add(
        $app->getContainer()->get('checkJwt')
    );

    $app->get('/produits[/[{filtering}]]', GetProduitsAction::class)->setName('produits');

    $app->get('/produit/{id}[/]', GetProduitByNumeroAction::class)->setName('produit');

    $app->get('/categories/{id_categorie}/produits[/]', GetProduitsByCategAction::class)->setName('produits_by_categ');
};
