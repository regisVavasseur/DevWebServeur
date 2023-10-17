<?php

namespace domain\service\auth;

class AuthProviderSignupException extends \Exception
{

        /**
        * @param string $getMessage
        */
        public function __construct(string $getMessage)
        {
        }
}