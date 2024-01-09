<?php

namespace pizzashop\commande\app\action;

use pizzashop\commande\domain\service\catalogue\iInfoProduit;
use pizzashop\commande\domain\service\commande\ServiceCommandeNotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class GetProduitByNumeroAction
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
            $product = $this->produit->getProduitByNumero($id);

            $reponseJson = [
                'type' => 'resource',
                'produit' => $product,
                'links' => [
                    'self' => RouteContext::fromRequest($request)->getRouteParser()->urlFor('produit', ['id' => $product->numero]),
                ]
            ];

            $response->getBody()->write(json_encode($reponseJson));

            return $response->withHeader('Content-Type', 'application/json');
        } catch (ServiceCommandeNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        } catch (ContainerExceptionInterface $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

    }
}