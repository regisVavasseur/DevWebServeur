<?php

namespace domain\provider;

use function PHPUnit\Framework\isEmpty;

class AuthProvider
{
    public function checkCredentials(string $username, string $password): void
    {
        if(!isEmpty($username) || !isEmpty($password)) {

        }
    }

    public function checkToken(string $token): void
    {

    }

    public function register(string $username, string $password): void
    {

    }

    public function activate(string $token): void
    {

    }

    public function resetPassword(string $token, string $old_password, string $new_password): void
    {

    }
}