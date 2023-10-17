<?php

namespace domain\service\auth;

use domain\dto\CredentialsDTO;
use domain\dto\TokenDTO;
use domain\dto\UserDTO;

class AuthService implements AuthServiceInterface
{

    public function signup(CredentialsDTO $credentialsDTO): UserDTO
    {

    }

    public function signin(CredentialsDTO $credentialsDTO): TokenDTO
    {

    }

    public function validate(TokenDTO $tokenDTO): UserDTO
    {

    }

    public function refresh(TokenDTO $tokenDTO): TokenDTO
    {

    }

    public function activate_signup(TokenDTO $tokenDTO): void
    {

    }

    public function reset_password(TokenDTO $tokenDTO, CredentialsDTO $credentialsDTO): void
    {

    }
}