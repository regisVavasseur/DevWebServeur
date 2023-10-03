<?php
declare(strict_types=1);

use pizzashop\shop\app\contollers\GetCommandeAction;
use pizzashop\shop\app\controllers\AccederCommandeAction;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):void {

    $app->post('/commandes[/]', \pizzashop\shop\app\actions\CreerCommandeAction::class)
        ->setName('creer_commande');

    $app->get('/commandes/{id_commande}[/]', AccederCommandeAction::class)
        ->setName('commande');

    $app->get('/commandes/{id}[/]', GetCommandeAction::class)->setName('commandes');
};