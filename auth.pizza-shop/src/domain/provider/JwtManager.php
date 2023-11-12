<?php

namespace pizzashop\auth\api\domain\provider;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use UnexpectedValueException;

class JwtManager
{
    private string $secret;
    private int $expirationTime;
    private string $issuer;

    public function __construct(string $secret, int $expirationTime)
    {
        $this->secret = $secret;
        $this->expirationTime = $expirationTime;
    }

    public function create(array $payload): string
    {
        $issuedAt = time();
        // Signing with HS512 algorithm

        return JWT::encode([
            'iss' => $this->issuer,
            'iat' => $issuedAt,
            'exp' => $issuedAt + $this->expirationTime, // Issue time + expiration
            'upr' => $payload // User profile data
        ], $this->secret, 'HS512');
    }

    /**
     * @throws JwtManagerExpiredTokenException
     * @throws JwtManagerInvalidTokenException
     */
    public function validate(string $jwtToken): array
    {
        try {
            $decoded = JWT::decode($jwtToken, new Key($this->secret, 'HS512'));
            return (array)$decoded->upr; // Return user profile from token
        } catch (ExpiredException $e) {
            throw new JwtManagerExpiredTokenException("Expired jwt token");
        } catch (SignatureInvalidException | UnexpectedValueException $e) {
            throw new JwtManagerInvalidTokenException("Invalid jwt token");
        }
    }

    public function setIssuer(string $issuer): void
    {
        $this->issuer = $issuer;
    }

}