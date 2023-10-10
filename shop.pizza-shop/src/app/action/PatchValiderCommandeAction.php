<?php

namespace pizzashop\shop\app\action;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use pizzashop\shop\app\action\Action;
use pizzashop\shop\domain\service\catalogue\CatalogueService;
use pizzashop\shop\domain\service\commande\iCommander;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ServiceCommandeInvalidException;
use Slim\Exception\HttpNotFoundException;

class PatchValiderCommandeAction
{
    private iCommander $commander;

    public function __construct(iCommander $commander)
    {
        $this->commander = $commander;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id'] ?? 0;

        $dataJson = [];

        $logger = new Logger('app.logger');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../../../logs/errors.log', Level::Error));

        try {
            $service = $this->commander;
            $service->validerCommande($id);
        } catch (ServiceCommandeInvalidException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }
        $dataJson['type'] = 'commande';
        $dataJson['status'] = 'success';
        $dataJson['commande'] = $service->accederCommande($id);


        return $response->getBody()->write(json_encode($dataJson));


    }
}