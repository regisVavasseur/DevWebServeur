<?php

namespace pizzashop\shop\domain\utils;

use GuzzleHttp\Client;
use pizzashop\shop\domain\dto\item\ItemDTO;

class CatalogDataProvider
{

    //localhost:3080/produit/{id} GET
    //id -> numero du produit pas l'id (ex: 10)
    //rien a ajouter sauf id

    //Get ItemInfos
    //Reçois un ItemDTO
    //Vérifie si le produit existe dans le catalogue avec un appel à l'API Catalogue
    //Si le produit existe, retourne un ItemDTO complété avec les setters grâce aux infos du produit
    //Si le produit n'existe pas, throw une exception

    private $uri;

    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    public function getItemInfos(ItemDTO $itemDTO): ItemDTO {
        $numero = $itemDTO->getNumero();
        $taille = $itemDTO->getTaille();

        $client = new Client([
            'base_uri' => $this->uri,
            'timeout' => 20.0,
        ]);

        $response = $client->request('GET', '/produits/'.$numero, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'connection' => 'keep-alive'
            ]
        ]);

        $code = $response->getStatusCode();

        if ($code !== 200) {
            throw new \Exception('Produit inexistant');
        }

        $body = $response->getBody()->getContents();

        $produit = json_decode($body, true)['produit'];

        $itemDTO->setLibelle($produit['libelle']);
        $itemDTO->setLibelleTaille(
            $produit['tarifs'][$taille-1]['taille']['libelle']
        );
        $itemDTO->setTarif(floatval(
            $produit['tarifs'][$taille-1]['tarif']
        ));

        return $itemDTO;

    }


}