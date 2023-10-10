<?php

namespace pizzashop\shop\app\action;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use pizzashop\shop\domain\service\catalogue\CatalogueService;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use pizzashop\shop\domain\service\commande\ServiceCommandeInvalidException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

class PatchValiderCommandeAction extends Action
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id_commande'] ?? 0;

        $dataJson = [];

        $logger = new Logger('app.logger');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../../../logs/errors.log', Level::Error));
        $catalogueService = new CatalogueService();

        try {
            $service = new ServiceCommande($catalogueService, $logger);
            $service->validerCommande($id);
        } catch (ServiceCommandeInvalidException $e) {
            throw new HttpNotFoundException($request, "Commande non trouvée");
        }
        $dataJson['type'] = 'commande';
        $dataJson['status'] = 'success';
        $dataJson['commande'] = $service->accederCommande($id);


        $response->getBody()->write(json_encode($dataJson));

        return $response;


    }
}