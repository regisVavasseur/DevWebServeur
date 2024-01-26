<?php

use pizzashop\gateway\app\action\CatalogueAction;
use pizzashop\gateway\app\action\CommandeAction;
use pizzashop\gateway\app\action\UserAction;
use Psr\Container\ContainerInterface;

return [
    CatalogueAction::class => function (ContainerInterface $container) {
        return new CatalogueAction($container->get('uri.catalogue'));
    },
    CommandeAction::class => function (ContainerInterface $container) {
        return new CommandeAction($container->get('uri.commande'));
    },
    UserAction::class => function (ContainerInterface $container) {
        return new UserAction($container->get('uri.auth'));
    }
];