<?php

namespace pizzashop\shop\app\action;

use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\dto\item\ItemDTO;
use pizzashop\shop\domain\entities\catalogue\Taille;
use pizzashop\shop\domain\service\commande\iCommander;
use pizzashop\shop\domain\service\commande\ServiceCommandeNotFoundException;
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

        try {
            $commandeDTO2 = $this->iCommander->creerCommande(
                new CommandeDTO(
                    $data['type_livraison'],
                    $data['mail_client'],
                    array_map(
                        fn($item) => new ItemDTO(
                            $item['numero'],
                            $item['taille'],
                            $item['quantite']
                        ),
                        $data['items']
                    )
                )
            );
        } catch (ServiceCommandeNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $dataJson = [
            'type' => 'resource',
            'commande' => $commandeDTO2->toArray()
        ];

        $response->getBody()->write(
            json_encode($dataJson)
        );

        return $response;
    }
}