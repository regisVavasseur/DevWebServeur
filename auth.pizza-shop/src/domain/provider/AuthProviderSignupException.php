<?php

namespace pizzashop\auth\api\domain\provider;

class AuthProviderSignupException extends \Exception
{

        /**
        * @param string $getMessage
        */
        public function __construct(string $getMessage)
        {
        }
}