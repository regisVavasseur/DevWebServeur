<?php

namespace pizzashop\shop\app\contollers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

interface Action
{
    public function __invoke(Request $request, Response $response, array $args);
}