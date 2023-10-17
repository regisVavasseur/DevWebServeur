<?php

namespace domain\service\auth;

class AuthProvider
{
    public function checkCredentials(string $username, string $password): void
    {

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