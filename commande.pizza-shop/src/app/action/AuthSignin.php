<?php

namespace pizzashop\commande\app\action;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthSignin extends Action
{

    private $uri;

    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @throws GuzzleException
     */
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $args = json_decode($request->getBody()->getContents(), true);

        $client = new Client([
            'base_uri' => $this->uri,
            'timeout' => 20.0,
        ]);

        $responseApiAuth = $client->request('POST', '/api/users/signin', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'connection' => 'keep-alive'
            ],
            'json' => [
                'email' => $args['email'],
                'password' => $args['password']
            ]
        ]);

        $code = $responseApiAuth->getStatusCode();

        $response->getBody()->write(json_encode(json_decode($responseApiAuth->getBody(), true)));

        return $response->withHeader('Content-Type', 'application/json')->withStatus($code);
    }
}