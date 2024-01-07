<?php

namespace pizzashop\shop\domain\service\catalogue;

use pizzashop\shop\domain\dto\catalogue\ProduitDTO;

interface iInfoProduit
{
    public function getProduit(int $num): ProduitDTO;
    public function getProduits(): array;
    public function getProduitsByCategorie(int $categorie_id): array;
    public function getProduitByNumero(int $numero): ProduitDTO;

}