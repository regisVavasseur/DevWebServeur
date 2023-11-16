<?php

namespace pizzashop\shop\app\action;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthSignin extends Action
{

    /**
     * @throws GuzzleException
     */
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $client = new Client([
            'base_uri' => 'auth.pizza-shop.local',
            'timeout' => 2.0,
        ]);

        $responseApiAuth = $client->request('POST', '/api/users/signin', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'connection' => 'keep-alive'
            ],
            'form_params' => [
                'email' => $request->getParsedBody()['email'],
                'password' => $request->getParsedBody()['password']
            ]
        ]);

        $code = $responseApiAuth->getStatusCode();

        $response->getBody()->write(json_encode($responseApiAuth->getBody()));

        return $response->withHeader('Content-Type', 'application/json')->withStatus($code);
    }
}