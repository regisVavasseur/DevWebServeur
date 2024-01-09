<?php

use pizzashop\commande\app\action\AuthRefresh;
use pizzashop\commande\app\action\AuthSignin;
use pizzashop\commande\app\action\AuthValidate;
use pizzashop\commande\app\action\GetCommandeAction;
use pizzashop\commande\app\action\GetProduitByNumeroAction;
use pizzashop\commande\app\action\GetProduitsAction;
use pizzashop\commande\app\action\GetProduitsByCategAction;
use pizzashop\commande\app\action\PatchValiderCommandeAction;
use pizzashop\commande\app\action\PostCreerCommandeAction;
use Psr\Container\ContainerInterface;

return [
    GetCommandeAction::class => function (ContainerInterface $container) {
        return new GetCommandeAction($container->get('commande.service'));
    },

    PatchValiderCommandeAction::class => function (ContainerInterface $container) {
        return new PatchValiderCommandeAction($container->get('commande.service'));
    },
    PostCreerCommandeAction::class => function (ContainerInterface $container) {
        return new PostCreerCommandeAction(
            $container->get('commande.service'),
            $container->get('uri.auth')
        );
    },

    AuthSignin::class => fn(ContainerInterface $container) => new AuthSignin($container->get('uri.auth')),

    AuthValidate::class => fn(ContainerInterface $container) => new AuthValidate($container->get('uri.auth')),

    AuthRefresh::class => fn(ContainerInterface $container) => new AuthRefresh($container->get('uri.auth')),

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