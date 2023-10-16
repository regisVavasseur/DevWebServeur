<?php

namespace pizzashop\shop\app\action;

use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\dto\item\ItemDTO;
use pizzashop\shop\domain\service\commande\iCommander;
use ServiceCommandeInvalidException;
use ServiceCommandeNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PostCreerCommandeAction
{

    private iCommander $iCommander;

    public function __construct(iCommander $commande)
    {
        $this->iCommander = $commande;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $data = json_decode($request->getBody()->getContents(), true);
        $mail_client = $data['mail_client'];
        $type_livraison = $data['type_livraison'];
        $items = $data['items'];
        $itemsDTO = [];
        foreach ($items as $item) {
            $numero = $item['numero'];
            $taille = $item['taille'];
            $quantite = $item['quantite'];
            $itemDTO = new ItemDTO($numero, $taille, $quantite);
            $itemsDTO[] = $itemDTO;
        }

        $commandeDTO = new CommandeDTO($type_livraison, $mail_client, $itemsDTO);

        try {
            $commande = $this->iCommander;
            $commandeDTO2 = $commande->creerCommande($commandeDTO);
        } catch (\pizzashop\shop\domain\service\commande\ServiceCommandeNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $dataJson = [
            'type' => 'resource',
            'commande' => $commandeDTO2->toArray()
        ];

        $response->getBody()->write(json_encode($dataJson));

        return $response;
    }
}