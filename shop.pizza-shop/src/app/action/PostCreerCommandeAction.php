<?php

namespace pizzashop\shop\app\action;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use pizzashop\shop\domain\service\catalogue\CatalogueService;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use ServiceCommandeInvalidException;
use ServiceCommandeNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PostCreerCommandeAction
{
    public function __invoke(Request $request, Response $response, array $args)
    {
        $id = $args['id'] ?? 0;

        $dataJson = [];

        $logger = new Logger('app.logger');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../../../logs/errors.log', Level::Error));

        $catalogueService = new CatalogueService();


        try {
            $service = new ServiceCommande($catalogueService, $logger);
            $service->creerCommande($id);
        } catch (ServiceCommandeInvalidException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }
        $dataJson['status'] = '201 CREATED';
        $dataJson['Header'] = 'Location: /commandes/' . $id . '/';
        $dataJson['commande'] = $service->accederCommande($id);

        return $response->getBody()->write(json_encode($dataJson));


    }
}