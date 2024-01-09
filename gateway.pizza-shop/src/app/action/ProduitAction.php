<?php

namespace pizzashop\gateway\app\action;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpUnauthorizedException;

class ProduitAction extends Action
{

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        try {
            $response = $this->service->request($request->getMethod(),$request->getUri()->getPath(),
                [
                    'headers' => ['Authorization' => $request->getHeader('Authorization')],
                    'json' => $request->getParsedBody()
                ]);
        } catch (ConnectException | ServerException $e) {
            throw new HttpInternalServerErrorException($e->getCode(), $e->getMessage());
        } catch (ClientException $e) {
            if ($e->getCode() === 401) {
                throw new HttpUnauthorizedException($e->getCode(),$e->getMessage());
            }
            throw new HttpInternalServerErrorException($e->getCode(), $e->getMessage());
        }
    }
}