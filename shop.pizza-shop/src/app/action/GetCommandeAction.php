<?php

namespace pizzashop\shop\app\contollers;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use pizzashop\shop\domain\service\catalogue\CatalogueService;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use ServiceCommandeNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class GetCommandeAction implements Action
{
    public function __invoke(Request $request, Response $response, array $args)
    {
        $id = $args['id'] ?? 0;

        $logger = new Logger('app.logger');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../../../logs/errors.log', Level::Error));
        $catalogueService = new CatalogueService();

        try {
            $service = new ServiceCommande($catalogueService, $logger);
            $commandeDto = $service->accederCommande($id);
        } catch (ServiceCommandeNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $responseJson = [
            'type' => 'resource',
            'commande' => $commandeDto,
            'links' => [
                'self' => [
                    'href' => '/commandes/'.$commandeDto->getId()
                ],
                'valider' => [
                    'href' => '/commandes/'.$commandeDto->getId()
                ]
            ],
        ];

        $response->getBody()->write(json_encode($responseJson));

    }
}