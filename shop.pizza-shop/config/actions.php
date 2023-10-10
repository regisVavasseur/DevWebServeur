<?php

use pizzashop\shop\app\action\GetCommandeAction;
use Psr\Container\ContainerInterface;

return [
    GetCommandeAction::class => function(ContainerInterface $container) {
    return new GetCommandeAction($container->get('commande.service'));
    }
];