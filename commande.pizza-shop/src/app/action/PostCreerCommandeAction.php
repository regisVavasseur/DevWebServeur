<?php

namespace pizzashop\commande\app\action;

use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\dto\item\ItemDTO;
use pizzashop\shop\domain\service\commande\iCommander;
use pizzashop\shop\domain\service\commande\ServiceCommandeNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PostCreerCommandeAction
{

    private iCommander $iCommander;
    private $uri;

    public function __construct(iCommander $commande, $uri)
    {
        $this->iCommander = $commande;
        $this->uri = $uri;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {

        //récupération du mail de l'utilisateur connecté via le middleware CheckJWT
        // issu du token JWT présenté par le client dans le header Authorization de la requête.
        $email = $request->getAttribute('email');

        $data = json_decode($request->getBody()->getContents(), true);

        try {
            $commandeDTO2 = $this->iCommander->creerCommande(
                new CommandeDTO(
                    $data['type_livraison'],
                    $email,
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
            'commande' => $commandeDTO2
        ];

        $response->getBody()->write(
            json_encode($dataJson)
        );

        return $response;
    }
}