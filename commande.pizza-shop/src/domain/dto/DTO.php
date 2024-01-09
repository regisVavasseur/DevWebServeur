<?php

namespace pizzashop\commande\domain\dto;

use Illuminate\Database\Eloquent\Model;

abstract class DTO
{

    public function __toString(): string
    {
        return json_encode(get_object_vars($this));
    }

}