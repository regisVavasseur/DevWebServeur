<?php


use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use pizzashop\shop\domain\middlewares\BeforeCheckJWT;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use Psr\Container\ContainerInterface;

return [
    'logger' => function(ContainerInterface $container) {
        $logger = new Logger('app.logger');
        $logger->pushHandler(new StreamHandler($container->get('logger.file'), $container->get('logger.level')));
        return $logger;
    },
    'commande.service' => function(ContainerInterface $container) {
        return new ServiceCommande($container->get('logger'));
    },
    'checkJwt' => function(ContainerInterface $container) {
        return new BeforeCheckJWT($container->get('uri.auth'));
    },

];