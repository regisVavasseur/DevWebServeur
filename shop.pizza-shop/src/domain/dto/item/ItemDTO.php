<?php

namespace pizzashop\shop\domain\dto\item;

use pizzashop\shop\domain\dto\DTO;
use pizzashop\shop\domain\entities\catalogue\Produit;
use pizzashop\shop\domain\entities\catalogue\Taille;

class ItemDTO extends DTO
{
    private int $numero;
    private string $libelle;
    private int $taille;
    private string $libelle_taille;
    private float $tarif;
    private int $quantite;

    public function __construct(int $numero, int $taille, int $quantite)
    {
        $this->numero = $numero;
        $this->libelle = Produit::where('numero', $numero)->firstOrFail()->libelle;
        $this->taille = $taille;
        $this->libelle_taille = Taille::where('id', $taille)->firstOrFail()->libelle;
        $this->tarif = Produit::where('numero', $numero)->firstOrFail()
            ->tarif()->where('taille_id', $taille)->firstOrFail()->tarif;
        $this->quantite = $quantite;
    }


    public function getNumero(): int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }

    public function getTaille(): int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): void
    {
        $this->taille = $taille;
    }

    public function getLibelleTaille(): string
    {
        return $this->libelle_taille;
    }

    public function setLibelleTaille(string $libelle_taille): void
    {
        $this->libelle_taille = $libelle_taille;
    }

    public function getQuantite(): int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): void
    {
        $this->quantite = $quantite;
    }

    public function getPrix(): float
    {
        return $this->quantite * $this->tarif;
    }

    public function getTarif(): float
    {
        return $this->tarif;
    }

    public function setTarif(float $tarif): void
    {
        $this->tarif = $tarif;
    }

    public function toArray(): array
    {
        return [
            'numero' => $this->numero,
            'libelle' => $this->libelle,
            'taille' => $this->taille,
            'quantite' => $this->quantite,
            'libelle_taille' => $this->libelle_taille,
            'tarif' => $this->tarif
        ];
    }

}