<?php

use pizzashop\shop\app\action\AuthSignin;
use pizzashop\shop\app\action\AuthValidate;
use pizzashop\shop\app\action\GetCommandeAction;
use pizzashop\shop\app\action\PatchValiderCommandeAction;
use pizzashop\shop\app\action\PostCreerCommandeAction;
use Psr\Container\ContainerInterface;

return [
    GetCommandeAction::class => function (ContainerInterface $container) {
        return new GetCommandeAction($container->get('commande.service'));
    },

    PatchValiderCommandeAction::class => function (ContainerInterface $container) {
        return new PatchValiderCommandeAction($container->get('commande.service'));
    },
    PostCreerCommandeAction::class => function (ContainerInterface $container) {
        return new PostCreerCommandeAction($container->get('commande.service'));
    },

    AuthSignin::class => fn(ContainerInterface $container) => new AuthSignin($container->get('uri.auth')),

    AuthValidate::class => fn(ContainerInterface $container) => new AuthValidate($container->get('uri.auth')),
];