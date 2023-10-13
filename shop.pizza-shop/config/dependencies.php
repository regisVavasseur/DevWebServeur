<?php


use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use pizzashop\shop\domain\service\catalogue\CatalogueService;
use pizzashop\shop\domain\service\commande\ServiceCommande;
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
];