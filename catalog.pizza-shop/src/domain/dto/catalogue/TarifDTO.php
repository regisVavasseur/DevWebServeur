<?php

namespace pizzashop\catalog\domain\dto\catalogue;

class TarifDTO extends \pizzashop\catalog\domain\dto\DTO
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
