<?php
declare(strict_types=1);

use pizzashop\shop\app\action\GetCommandeAction;
use pizzashop\shop\app\controllers\PatchValiderCommandeAction;


return function( \Slim\App $app):void {

    //$app->post('/commandes[/]', \pizzashop\shop\app\actions\CreerCommandeAction::class)->setName('creer_commande');

    $app->patch('/commandes/{id_commande}[/]', PatchValiderCommandeAction::class)->setName('commande');

    $app->get('/commandes/{id}[/]', GetCommandeAction::class)->setName('commandes');
};