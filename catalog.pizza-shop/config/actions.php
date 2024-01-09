<?php

use pizzashop\catalog\app\action\GetProduitByNumeroAction;
use pizzashop\catalog\app\action\GetProduitsAction;
use pizzashop\catalog\app\action\GetProduitsByCategAction;
use Psr\Container\ContainerInterface;

return [

    GetProduitsAction::class => function (ContainerInterface $container) {
        return new GetProduitsAction($container->get('catalogue.service'));
    },

    GetProduitByNumeroAction::class => function (ContainerInterface $container) {
        return new GetProduitByNumeroAction($container->get('catalogue.service'));
    },

    GetProduitsByCategAction::class => function (ContainerInterface $container) {
        return new GetProduitsByCategAction($container->get('catalogue.service'));
    },

];