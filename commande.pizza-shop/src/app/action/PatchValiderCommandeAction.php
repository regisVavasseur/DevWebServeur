<?php

namespace pizzashop\commande\app\action;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use pizzashop\commande\domain\service\commande\iCommander;
use pizzashop\commande\domain\service\commande\ServiceCommandeInvalidException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
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

        //récupération du mail de l'utilisateur connecté via le middleware CheckJWT
        // issu du token JWT présenté par le client dans le header Authorization de la requête.
        $email = $request->getAttribute('email');

        $id = $args['id_commande'] ?? 0;

        $dataJson = [];

        $logger = new Logger('app.logger');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../../../logs/errors.log', Level::Error));

        try {
            $service = $this->commander;
            $service->validerCommande($id, $email);
        } catch (ServiceCommandeInvalidException $e) {
            if ($e->getCode() == 400) {
               throw new HttpBadRequestException($request, $e->getMessage());
            }
            if ($e->getCode() == 404) {
                throw new HttpNotFoundException($request, $e->getMessage());
            }
        }
        $dataJson['type'] = 'commande';
        $dataJson['status'] = 'success';
        $dataJson['commande'] = $service->accederCommande($id, $email);


        $response->getBody()->write(json_encode($dataJson));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

    }
}