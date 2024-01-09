<?php

namespace pizzashop\catalog\domain\middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Cors
{

    public function __invoke(ServerRequestInterface $rq, RequestHandlerInterface $next): ResponseInterface
    {
        $response = $next->handle($rq);

        $response = $response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', $rq->getHeaderLine('Access-Control-Request-Headers'))
            ->withHeader('Access-Control-Allow-Methods', $rq->getHeaderLine('Access-Control-Request-Method'))
            ->withHeader('Access-Control-Max-Age', 3600)
            ->withHeader('Access-Control-Allow-Credentials', 'true');

        return $response;
    }

}