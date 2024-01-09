<?php

namespace pizzashop\commande\domain\dto\catalogue;

class TarifDTO extends \pizzashop\commande\domain\dto\DTO
{

    public int $produit_numero;
    public TailleDTO $taille;
    public float $tarif;

    public function __construct(int $produit_numero, TailleDTO $taille, float $tarif)
    {
        $this->produit_numero = $produit_numero;
        $this->taille = $taille;
        $this->tarif = $tarif;
    }

}
