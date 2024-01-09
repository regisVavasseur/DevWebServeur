<?php


use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use pizzashop\commande\domain\middlewares\BeforeCheckJWT;
use pizzashop\commande\domain\service\catalogue\CatalogueService;
use pizzashop\commande\domain\service\commande\ServiceCommande;
use Psr\Container\ContainerInterface;

return [
    'logger' => function(ContainerInterface $container) {
        $logger = new Logger('app.logger');
        $logger->pushHandler(new StreamHandler($container->get('logger.file'), $container->get('logger.level')));
        return $logger;
    },
    'catalogue.service' => function(ContainerInterface $container) {
        return new CatalogueService();
    },
    'commande.service' => function(ContainerInterface $container) {
        return new ServiceCommande($container->get('catalogue.service'), $container->get('logger'));
    },

    'checkJwt' => function(ContainerInterface $container) {
        return new BeforeCheckJWT($container->get('uri.auth'));
    },

];