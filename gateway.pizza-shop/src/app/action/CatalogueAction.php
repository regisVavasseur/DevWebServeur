<?php

namespace pizzashop\gateway\app\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CatalogueAction extends Action
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        //enelever /api/ de la route et héritage de la méthode parente
        $route = substr($request->getUri()->getPath(), 4);
        return parent::__invoke($request->withUri($request->getUri()->withPath($route)), $response, $args);
    }
}