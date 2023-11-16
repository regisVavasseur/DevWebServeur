<?php
declare(strict_types=1);

use pizzashop\shop\app\action\AuthSignin;
use pizzashop\shop\app\action\AuthValidate;
use pizzashop\shop\app\action\GetCommandeAction;
use pizzashop\shop\app\action\PatchValiderCommandeAction;
use pizzashop\shop\app\action\PostCreerCommandeAction;
use Slim\App;


return function( App $app):void {

    $app->post('/commandes[/]', PostCreerCommandeAction::class)->setName('creer_commande');

    $app->patch('/commandes/{id_commande}[/]', PatchValiderCommandeAction::class)->setName('patch_commandes');

    $app->get('/commandes/{id}[/]', GetCommandeAction::class)->setName('commandes');

    $app->post('/signin[/]', AuthSignin::class)->setName('signin');

    $app->get('/validate[/]', AuthValidate::class)->setName('validate');
};