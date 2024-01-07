<?php

namespace pizzashop\shop\domain\dto\catalogue;

class TailleDTO extends \pizzashop\shop\domain\dto\DTO
{

    public int $id;
    public string $libelle;

    public function __construct(int $id, string $libelle)
    {
        $this->id = $id;
        $this->libelle = $libelle;
    }

}
