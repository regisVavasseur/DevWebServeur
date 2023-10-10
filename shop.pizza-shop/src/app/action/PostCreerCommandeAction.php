<?php

namespace pizzashop\shop\app\action;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\service\catalogue\CatalogueService;
use pizzashop\shop\domain\service\commande\iCommander;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use ServiceCommandeInvalidException;
use ServiceCommandeNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PostCreerCommandeAction
{

    private iCommander $iCommander;

    public function __construct($commande)
    {
        $this->iCommander = $commande;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $mail_client = "miche@gmal.com";
        $type_livraison = 2;
        $items = [
            "numero" => 2,
            "taille" => 1,
            "quantite" => 1
        ];

        $commandeDTO = new CommandeDTO($type_livraison, $mail_client, $items);

        try {
            $commande = $this->iCommander;
            $commandeDTO2 = $commande->creerCommande($commandeDTO);
        } catch (\pizzashop\shop\domain\service\commande\ServiceCommandeNotFoundException) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        //$dataJson['status'] = '201 CREATED';
        //$dataJson['Header'] = 'Location: /commandes/' . $id . '/';
        //$dataJson['commande'] = $service->accederCommande($id);

        $dataJson = [
            'type' => 'resource',
            'commande' => $commandeDTO2->toArray();
        ];

        $response->getBody()->write(json_encode($dataJson));

        return $response;
    }
}