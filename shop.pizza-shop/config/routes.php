<?php
declare(strict_types=1);

use pizzashop\shop\app\contollers\GetCommandeAction;
use pizzashop\shop\app\controllers\getValiderCommandeAction;


return function( \Slim\App $app):void {

    //$app->post('/commandes[/]', \pizzashop\shop\app\actions\CreerCommandeAction::class)->setName('creer_commande');

    $app->patch('/commandes/{id_commande}[/]', getValiderCommandeAction::class)->setName('commande');

    $app->get('/commandes/{id}[/]', GetCommandeAction::class)->setName('commandes');
};