<?php

namespace pizzashop\shop\app\action;

use pizzashop\shop\domain\service\commande\iCommander;
use pizzashop\shop\domain\service\commande\ServiceCommandeNotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class GetCommandeAction
{

    private iCommander $commander;

    public function __construct(iCommander $commander)
    {
        $this->commander = $commander;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $args['id'] ?? 0;

        try {
            $service = $this->commander;
            $commandeDto = $service->accederCommande($id);
        } catch (ServiceCommandeNotFoundException $e) {
            throw new HttpNotFoundException($request, 'test'.$e->getMessage());
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            throw new HttpNotFoundException($request, "test1".$e->getMessage());
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        $responseJson = [
            'type' => 'resource',
            'commande' => $commandeDto->__toString(),
//            'links' => [
//                'self' => ['href' => $routeParser->urlFor('getCommande', ['id' => $commandeDto->getId()])],
//                'valider' => ['href' => $routeParser->urlFor('patchValiderCommande', ['id' => $commandeDto->getId()])],
//            ],
        ];

        $response->getBody()->write(json_encode($responseJson));

        return $response;

//        $response->getBody()->write(json_encode($responseJson));
//        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

    }
}