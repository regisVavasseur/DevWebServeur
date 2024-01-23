<?php

namespace pizzashop\gateway\app\action;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpUnauthorizedException;

abstract class Action
{
    protected string $uri;

    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args){
        try {

            //récupérer la route demandée + la méthode et body + headers
            $route = $request->getUri()->getPath();
            $method = $request->getMethod();
            $body = $request->getParsedBody();
            $headers = $request->getHeaders();

            //envoyer la requête à l'API catalogue
            $client = new \GuzzleHttp\Client([
                'base_uri' => $this->uri,
                'timeout' => 60.0,
            ]);

            $response = $client->request($method, $route, [
                'headers' => $headers,
                'json' => $body
            ]);

            //récupérer le code de retour
            $code = $response->getStatusCode();

            if ($code !== 200) {
                //retourner l'erreur avec le code et le message de l'API catalogue
                $body = $response->getBody()->getContents();
                $body = json_decode($body, true);
                throw new HttpUnauthorizedException($request, $body['message'], $body['code']);
            }

            //retourner la réponse de l'API catalogue
            $body = $response->getBody()->getContents();
            $body = json_decode($body, true);
            $response = $response->withStatus($code)->withHeader('Content-Type', 'application/json');

            $response->getBody()->write(json_encode($body));

            return $response;

        } catch (ConnectException | ServerException $e) {
            throw new HttpInternalServerErrorException($request, $e->getMessage());
        } catch (ClientException $e) {
            if ($e->getCode() === 401) {
                throw new HttpUnauthorizedException($request, $e->getMessage());
            }
            throw new HttpInternalServerErrorException($request, $e->getMessage());
        }
    }
}