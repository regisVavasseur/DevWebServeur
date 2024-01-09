<?php

namespace pizzashop\commande\domain\dto\catalogue;

class CategorieDTO extends \pizzashop\commande\domain\dto\DTO
{

    public int $id;
    public string $libelle;

    public function __construct(int $id_categorie, string $libelle_categorie)
    {
        $this->id = $id_categorie;
        $this->libelle = $libelle_categorie;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'libelle' => $this->libelle
        ];
    }

}