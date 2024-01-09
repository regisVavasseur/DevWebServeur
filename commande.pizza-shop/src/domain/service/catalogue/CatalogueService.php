<?php

namespace pizzashop\commande\domain\service\catalogue;

use pizzashop\commande\domain\entities\catalogue\Produit;
use pizzashop\commande\domain\dto\catalogue\ProduitDTO;

class CatalogueService implements iInfoProduit
{

    public function getProduit(int $num): ProduitDTO
    {
        return Produit::where('numero', $num)->firstOrFail()->toDTO();
    }

    public function getProduits($filtre): array
    {
        $produits = Produit::query();

        if (isset($filtre)) {
            $produits->where('libelle', 'like', '%' . $filtre . '%')
                ->orWhere('description', 'like', '%' . $filtre . '%');
        }

        return $produits->get()
            ->map(
                function ($produit) {
                    return $produit->toDTO();
                }
            )->toArray();

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

    public function getProduitByNumero(int $numero): ProduitDTO {
        return Produit::where('numero', $numero)->firstOrFail()->toDTO();
    }
}