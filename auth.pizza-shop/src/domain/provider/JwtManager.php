<?php

namespace domain\provider;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use pizzashop\shop\domain\service\catalogue\JwtManagerExpiredTokenException;
use pizzashop\shop\domain\service\catalogue\JwtManagerInvalidTokenException;
use Respect\Validation\Exceptions\DomainException;
use UnexpectedValueException;

class JwtManager
{
    private string $secret;
    private int $expirationTime;
    private string $issuer;

    public function __construct(string $secret, int $expirationTime)   {
        $this->secret = $secret;
        $this->expirationTime = $expirationTime;
    }

    public function create(array $payload): string {
        $token = JWT::encode([
            'iss' => $this->issuer,
            'iat' => time(),
            'exp' => time() + $this->expirationTime,
            'upr' => $payload
        ], $this->secret, 'HS512');

        return $token;
    }

    public function validate(string $jwtToken): void {
        try {
            $jwtToken = JWT::decode($jwtToken,new Key($this->secret, 'HS512'));
        } catch (ExpiredException $e){
            throw new JwtManagerExpiredTokenException("Expired jwt token");
        } catch (SignatureInvalidException| UnexpectedValueException | DomainException){
            throw new JwtManagerInvalidTokenException("Invalid jwt token");
        }
    }

    /**
     * @param string $issuer
     */
    public function setIssuer(string $issuer): void
    {
        $this->issuer = $issuer;
    }




}