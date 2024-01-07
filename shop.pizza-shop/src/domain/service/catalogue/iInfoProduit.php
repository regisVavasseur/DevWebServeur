<?php

namespace pizzashop\shop\domain\service\catalogue;

use pizzashop\shop\domain\dto\catalogue\ProduitDTO;

interface iInfoProduit
{
    public function getProduit(int $num, int $taille): ProduitDTO;
    public function getProduits(): array;
    public function getProduitsByCategorie(string $categorie): array;
    public function getProduitById(int $id): ProduitDTO;

}