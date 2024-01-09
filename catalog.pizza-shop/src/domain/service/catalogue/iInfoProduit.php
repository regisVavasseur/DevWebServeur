<?php

namespace pizzashop\catalog\domain\service\catalogue;

use pizzashop\catalog\domain\dto\catalogue\ProduitDTO;

interface iInfoProduit
{
    public function getProduit(int $num): ProduitDTO;
    public function getProduits($filtre): array;
    public function getProduitsByCategorie(int $categorie_id): array;
    public function getProduitByNumero(int $numero): ProduitDTO;

}