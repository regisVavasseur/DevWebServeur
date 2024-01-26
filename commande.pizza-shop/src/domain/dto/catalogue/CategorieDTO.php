<?php

namespace pizzashop\shop\domain\dto\catalogue;

class CategorieDTO extends \pizzashop\shop\domain\dto\DTO
{

    public int $id;
    public string $libelle;

    public function __construct(int $id_categorie, string $libelle_categorie)
    {
        $this->id = $id_categorie;
        $this->libelle = $libelle_categorie;
    }

}