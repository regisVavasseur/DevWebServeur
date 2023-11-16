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
            'base_uri' => 'localhost:2780',
            'timeout' => 2.0,
        ]);

        $responseApiAuth = $client->request('POST', '/api/users/signin', [
            'headers' => [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
                'Access-Control-Allow-Headers' => 'Origin, Content-Type, X-Auth-Token',
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