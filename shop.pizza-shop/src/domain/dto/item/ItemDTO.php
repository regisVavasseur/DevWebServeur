<?php

namespace pizzashop\shop\domain\dto\item;

use pizzashop\shop\domain\dto\DTO;

class ItemDTO extends DTO
{
    private int $numero;
    private string $libelle;
    private int $taille;
    private int $quantite;
    private float $tarif;
    private string $libelle_taille;

    public function __construct(int $numero, int $taille, int $quantite)
    {
        $this->numero = $numero;
        $this->taille = $taille;
        $this->quantite = $quantite;
    }




    public function getLibelleTaille(): int
    {
        return $this->numero;
    }

    public function setLibelleTaille(string $taille_libelle): void
    {
        $this->libelle_taille = $taille_libelle;
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
        return $this->prix;
    }

    public function setPrix(float $tarif): void
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
            'libelle taille' => $this->libelle_taille,
            'tarif' => $this->tarif
        ];
    }

}