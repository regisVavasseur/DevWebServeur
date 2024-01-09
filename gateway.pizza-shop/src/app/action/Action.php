<?php

namespace pizzashop\gateway\app\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Action
{
    protected $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    abstract function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args);
}