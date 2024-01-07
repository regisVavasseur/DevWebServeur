<?php

namespace pizzashop\shop\app\action;

use pizzashop\shop\domain\service\catalogue\iInfoProduit;
use pizzashop\shop\domain\service\commande\ServiceCommandeNotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

class GetProduitsAction
{

    private iInfoProduit $produit;

    public function __construct(iInfoProduit $produit)
    {
        $this->produit = $produit;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $products = $this->produit->getProduits();

            $productData = array_map(function ($product) {
                return [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'uri' => '/products/' . $product->getId()
                ];
            }, $products);

            $response->getBody()->write(json_encode($productData));

            return $response->withHeader('Content-Type', 'application/json');
        } catch (ServiceCommandeNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        } catch (ContainerExceptionInterface $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }




       


    }
}