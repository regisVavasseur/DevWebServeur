<?php

use pizzashop\shop\app\action\GetCommandeAction;
use pizzashop\shop\app\action\PatchValiderCommandeAction;
use Psr\Container\ContainerInterface;

return [
    GetCommandeAction::class => function(ContainerInterface $container) {
    return new GetCommandeAction($container->get('commande.service'));
    },

    PatchValiderCommandeAction::class => function(ContainerInterface $container) {
    return new PatchValiderCommandeAction($container->get('commande.service'), $container->get('logger'));
    }
];