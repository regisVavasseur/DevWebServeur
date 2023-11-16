<?php

namespace pizzashop\auth\api\domain\provider;

class AuthServiceSignupException extends \Exception
{

    /**
     * @param string $getMessage
     */
    public function __construct(string $getMessage)
    {
    }
}