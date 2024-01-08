<?php

namespace pizzashop\shop\app\action;

use pizzashop\shop\domain\service\catalogue\iInfoProduit;
use pizzashop\shop\domain\service\commande\ServiceCommandeNotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

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
            $products = $this->produit->getProduits($args['filtering'] ?? null);

            $responseJson = [
                'type' => 'resource',

                'produits' => array_map(
                     function ($produit) use ($request) {
                        return array_merge(json_decode($produit, true), [
                            'links' => [
                                'self' => RouteContext::fromRequest($request)->getRouteParser()->urlFor('produit', ['id' => $produit->numero])
                            ]
                        ]);
                    },
                    $products
                ),
                'links' => [
                    'self' => RouteContext::fromRequest($request)->getRouteParser()->urlFor('produits'),
                ]
            ];

            $response->getBody()->write(json_encode($responseJson));

            return $response->withHeader('Content-Type', 'application/json');
        } catch (ServiceCommandeNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        } catch (ContainerExceptionInterface $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }




       


    }
}