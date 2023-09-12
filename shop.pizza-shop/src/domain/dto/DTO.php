<?php

namespace pizzashop\shop\domain\dto;

use Illuminate\Database\Eloquent\Model;

abstract class DTO
{

    public function toJSON(): string {
        return json_encode($this, JSON_PRETTY_PRINT);
    }

}