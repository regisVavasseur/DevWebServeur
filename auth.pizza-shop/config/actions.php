<?php

use pizzashop\auth\api\app\actions\SignInAction;
use Psr\Container\ContainerInterface;
use pizzashop\auth\api\app\actions\ValidateTokenAction;
use pizzashop\auth\api\app\actions\RefreshTokenAction;
use pizzashop\auth\api\domain\service\auth\AuthService;

return [
    SignInAction::class => function (ContainerInterface $container) {
        return new SignInAction($container->get(AuthService::class));
    },
    ValidateTokenAction::class => function (ContainerInterface $container) {
        return new ValidateTokenAction($container->get(AuthService::class));
    },
    RefreshTokenAction::class => function (ContainerInterface $container) {
        return new RefreshTokenAction($container->get(AuthService::class));
    },
];