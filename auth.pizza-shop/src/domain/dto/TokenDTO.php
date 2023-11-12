<?php

namespace pizzashop\auth\api\domain\dto;

namespace pizzashop\auth\api\domain\dto;

class TokenDTO
{
    public string $token;
    public string $refreshToken;

    public function __construct(string $token, string $refreshToken)
    {
        $this->token = $token;
        $this->refreshToken = $refreshToken;
    }
}