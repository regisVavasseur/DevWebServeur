<?php

namespace pizzashop\shop\domain\service\catalogue;

use pizzashop\shop\domain\entities\catalogue\Categorie;
use pizzashop\shop\domain\entities\catalogue\Produit;
use pizzashop\shop\domain\entities\catalogue\Taille;
use pizzashop\shop\domain\entities\catalogue\Tarif;
use pizzashop\shop\domain\service\catalogue\iInfoProduit;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;

class CatalogueService implements iInfoProduit
{

    public function getProduit(int $num, int $taille): ProduitDTO
    {

        $produit = Produit::where('numero', $num)->firstOrFail();
            $categorie = $produit->categorie()->firstOrFail();
            $taille = $produit->tailles()->firstOrFail();

        $produitDTO = new ProduitDTO(
            $produit->numero,
            $produit->libelle,
            $categorie->libelle,
            $taille->libelle,
            Tarif::where('produit_id', $produit->id)->where('taille_id', $taille->id)->firstOrFail()->tarif
        );

        return $produitDTO;
    }
}