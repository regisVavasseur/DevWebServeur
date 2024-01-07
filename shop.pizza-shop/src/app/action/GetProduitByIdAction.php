<?php

namespace pizzashop\shop\app\action;

use pizzashop\shop\domain\service\catalogue\iInfoProduit;
use pizzashop\shop\domain\service\commande\ServiceCommandeNotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

class GetProduitByIdAction
{

    private iInfoProduit $produit;

    public function __construct(iInfoProduit $produit)
    {
        $this->produit = $produit;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $args['id'] ?? 0;

        try {
            $product = $this->produit->getProduitById($id);

            $response->getBody()->write(json_encode($product));

            return $response->withHeader('Content-Type', 'application/json');
        } catch (ServiceCommandeNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        } catch (ContainerExceptionInterface $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }




       


    }
}