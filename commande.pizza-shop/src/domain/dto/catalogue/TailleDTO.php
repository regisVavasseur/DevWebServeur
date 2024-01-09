<?php

namespace pizzashop\commande\domain\dto\catalogue;

class TailleDTO extends \pizzashop\commande\domain\dto\DTO
{

    public int $id;
    public string $libelle;

    public function __construct(int $id, string $libelle)
    {
        $this->id = $id;
        $this->libelle = $libelle;
    }

}
