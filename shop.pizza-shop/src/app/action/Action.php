<?php

namespace pizzashop\shop\app\action;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Action
{

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    abstract function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args);
}