<?php

use pizzashop\shop\domain\dto\catalogue\ProduitDTO;

interface iInfoProduit
{
    public function getProduit(int $num, int $taille): ProduitDTO;
}