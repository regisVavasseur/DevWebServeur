<?php

namespace pizzashop\shop\app\action;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthValidate extends Action
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
        $token = $request->getHeader('Authorization')[0];
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

        $response->getBody()->write(json_encode(json_decode($responseApiAuth->getBody(), true)));

        return $response->withHeader('Content-Type', 'application/json')->withStatus($code);
    }
}