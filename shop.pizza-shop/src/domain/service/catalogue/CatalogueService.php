<?php

namespace pizzashop\shop\domain\service\catalogue;

use pizzashop\shop\domain\entities\catalogue\Produit;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;

class CatalogueService implements iInfoProduit
{

    public function getProduit(int $num): ProduitDTO
    {
        return Produit::where('numero', $num)->firstOrFail()->toDTO();
    }

    public function getProduits(): array
    {
        return Produit::all()->map(function ($produit) {
            return $produit->toDTO();
        })->toArray();
    }

    public function getProduitsByCategorie(int $categorie_id): array
    {
        return Produit::where('categorie_id', $categorie_id)->get()
        ->map(
            function ($produit) {
                return $produit->toDTO();
            }
        )->toArray();
    }

    public function getProduitByNumero(int $numero) : ProduitDTO {
        return Produit::where('numero', $numero)->firstOrFail()->toDTO();
    }
}