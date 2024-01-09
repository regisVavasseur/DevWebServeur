<?php

namespace pizzashop\commande\domain\middlewares;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;

class BeforeCheckJWT
{

    private $uri;

    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        //récupérer le token JWT présenté par le client.

        $tokenHeader = $request->getHeaderLine('Authorization');
        $token = !empty($tokenHeader) ? trim(str_replace('Bearer', '', $tokenHeader)) : '';


        //vérifier la présence d'un
        //token JWT. En cas d'absence, retourner une réponse d'erreur avec un code 401.

        if (empty($token)) {
            throw new HttpUnauthorizedException($request, 'Token manquant');
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
            throw throw new HttpUnauthorizedException($request, 'Token invalide');
        }

        $email = json_decode($responseApiAuth->getBody(), true)['email'];

        //ajouter l'email au body de la requête pour qu'il soit accessible dans les actions de l'application.
        $request = $request->withAttribute('email', $email);

        //poursuite du traitement de la requête.
        $response = $next->handle($request);

        //retour de la réponse.
        return $response;

    }
}