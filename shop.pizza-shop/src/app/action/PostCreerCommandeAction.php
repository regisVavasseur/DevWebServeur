<?php

namespace pizzashop\shop\app\action;

use GuzzleHttp\Client;
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
    private $uri;

    public function __construct(iCommander $commande, $uri)
    {
        $this->iCommander = $commande;
        $this->uri = $uri;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        //récupérer le token JWT présenté par le client.

        $tokenHeader = $request->getHeaderLine('Authorization');
        $token = !empty($tokenHeader) ? trim(str_replace('Bearer', '', $tokenHeader)) : '';

        //vérifier la présence d'un
        //token JWT. En cas d'absence, retourner une réponse d'erreur avec un code 401.

        if (empty($token)) {
            $response->getBody()->write(json_encode(['error' => 'Token manquant']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }

        //vérifier la validité du token JWT présenté.
        //Cette validité est vérifiée auprès de l'api authentification. Si le token est valide, la création de la
        //commande se poursuit en utilisant l'identité validée.
        //Si le token n'est pas valide, une réponse en erreur 401 est retournée au client.

        $client = new Client([
            'base_uri' => $this->uri,
            'timeout' => 20.0,
        ]);

        $responseApiAuth = $client->request('GET', '/api/users/validate', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'connection' => 'keep-alive',
                'Authorization' => $token
            ]
        ]);

        $code = $responseApiAuth->getStatusCode();

        if ($code !== 200) {
            $response->getBody()->write(json_encode(['error' => 'Token invalide']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }

        $email = json_decode($responseApiAuth->getBody(), true)['email'];

        ////////////////////////////////

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