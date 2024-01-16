<?php

namespace pizzashop\shop\domain\dto\item;

use pizzashop\shop\domain\dto\DTO;

class ItemDTO extends DTO
{
    public int $numero;
    public string $libelle;
    public int $taille;
    public string $libelle_taille;
    public float $tarif;
    public int $quantite;

    public function __construct(int $numero, int $taille, int $quantite)
    {
        $this->numero = $numero;
        $this->taille = $taille;
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

}