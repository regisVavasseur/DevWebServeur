<?php

namespace domain\service\auth;

class AuthServiceSignupException extends \Exception
{

    /**
     * @param string $getMessage
     */
    public function __construct(string $getMessage)
    {
    }
}