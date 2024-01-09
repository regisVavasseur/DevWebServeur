<?php
declare(strict_types=1);

use pizzashop\shop\app\action\GetCommandeAction;
use pizzashop\shop\app\action\PatchValiderCommandeAction;
use pizzashop\shop\app\action\PostCreerCommandeAction;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;


return function (App $app): void {

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

};
