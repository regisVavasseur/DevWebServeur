<?php

namespace pizzashop\auth\api\domain\provider;

class AuthProviderTokenException extends \Exception
{

    /**
     * @param string $string
     */
    public function __construct(string $string)
    {
    }
}