<?php

namespace pizzashop\shop\domain\service\catalogue;

use pizzashop\shop\domain\entities\catalogue\Produit;
use pizzashop\shop\domain\entities\catalogue\Tarif;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;

class CatalogueService implements iInfoProduit
{

    public function getProduit(int $num, int $taille): ProduitDTO
    {

        $produit = Produit::where('numero', $num)->firstOrFail();
            $categorie = $produit->categorie()->firstOrFail();
            $taille = $produit->tailles()->firstOrFail();
        return new ProduitDTO(
            $produit->numero,
            $produit->libelle,
            $categorie->libelle,
            $taille->libelle,
            Tarif::where('produit_id', $produit->id)->where('taille_id', $taille->id)->firstOrFail()->tarif
        );
    }

    public function getProduits(): array
    {
        $produits = Produit::all();
        $produitsDTO = [];
        foreach ($produits as $produit) {
            $categorie = $produit->categorie()->firstOrFail();
            $taille = $produit->tailles()->firstOrFail();
            $produitsDTO[] = new ProduitDTO(
                $produit->numero,
                $produit->libelle,
                $categorie->libelle,
                $taille->libelle,
                Tarif::where('produit_id', $produit->id)->where('taille_id', $taille->id)->firstOrFail()->tarif
            );
        }
        return $produitsDTO;
    }

    public function getProduitsByCategorie(string $categorie): array
    {
        $produits = Produit::whereHas('categorie', function ($query) use ($categorie) {
            $query->where('libelle', $categorie);
        })->get();
        $produitsDTO = [];
        foreach ($produits as $produit) {
            $categorie = $produit->categorie()->firstOrFail();
            $taille = $produit->tailles()->firstOrFail();
            $produitsDTO[] = new ProduitDTO(
                $produit->numero,
                $produit->libelle,
                $categorie->libelle,
                $taille->libelle,
                Tarif::where('produit_id', $produit->id)->where('taille_id', $taille->id)->firstOrFail()->tarif
            );
        }
        return $produitsDTO;
    }

    public function getProduitById(int $id) : ProduitDTO {
        $produit = Produit::where('id', $id)->firstOrFail();
        $categorie = $produit->categorie()->firstOrFail();
        $taille = $produit->tailles()->firstOrFail();
        return new ProduitDTO(
            $produit->numero,
            $produit->libelle,
            $categorie->libelle,
            $taille->libelle,
            Tarif::where('produit_id', $produit->id)->where('taille_id', $taille->id)->firstOrFail()->tarif
        );
    }
}