<?php

namespace pizzashop\shop\app\action;

use pizzashop\shop\domain\service\commande\ServiceCommandeNotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class GetCommandeAction extends Action
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): int
    {
        $id = $args['id'] ?? 0;

        try {
            $service = $this->container->get('commande.service');
            $commandeDto = $service->accederCommande($id);
        } catch (ServiceCommandeNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        $responseJson = [
            'type' => 'resource',
            'commande' => $commandeDto,
            'links' => [
                'self' => ['href' => $routeParser->urlFor('getCommande', ['id' => $commandeDto->getId()])],
                'valider' => ['href' => $routeParser->urlFor('patchValiderCommande', ['id' => $commandeDto->getId()])],
            ],
        ];

        return $response->getBody()->write(json_encode($responseJson));

    }
}