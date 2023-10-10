<?php

namespace pizzashop\shop\domain\dto\item;

use pizzashop\shop\domain\dto\DTO;

class ItemDTO extends DTO
{
    private int $id;
    private int $numero;
    private string $libelle;
    private int $taille;
    private int $quantite;
    private float $prix;

    public function __construct(int $id, int $numero, string $libelle, int $taille, int $quantite, float $prix)
    {
        $this->id = $id;
        $this->numero = $numero;
        $this->libelle = $libelle;
        $this->taille = $taille;
        $this->quantite = $quantite;
        $this->prix = $prix;

    }

    public function getId(): int
    {
        return $this->id;
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

    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }

    //create function toString
    public function __toStringArray(): array
    {
        return [
            'id' => $this->id,
            'numero' => $this->numero,
            'libelle' => $this->libelle,
            'taille' => $this->taille,
            'quantite' => $this->quantite,
            'prix' => $this->prix
        ];
    }

}