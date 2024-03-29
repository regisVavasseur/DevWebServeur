<?php

namespace pizzashop\shop\domain\dto\catalogue;

class ProduitDTO extends \pizzashop\shop\domain\dto\DTO
{

    public int $numero;
    public string $libelle;
    public string $description;
    public string $image;
    public CategorieDTO $categorie;

    public array $tarifs;

    public function __construct(int $numero, string $libelle, string $description, string $image, CategorieDTO $categorie, array $tarifs)
    {
        $this->numero = $numero;
        $this->libelle = $libelle;
        $this->description = $description;
        $this->image = $image;
        $this->categorie = $categorie;
        $this->tarifs = $tarifs;
    }

    public static function fromJson(string $json): ProduitDTO
    {
        $data = json_decode($json, true);
        
    }

}