<?php


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use pizzashop\catalog\domain\service\catalogue\CatalogueService;
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


];