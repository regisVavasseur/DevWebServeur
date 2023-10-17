<?php

namespace domain\service\auth;

use domain\dto\CredentialsDTO;
use domain\dto\TokenDTO;
use domain\dto\UserDTO;
use domain\provider\AuthProvider;
use domain\provider\JwtManager;
use pizzashop\shop\domain\service\catalogue\AuthProviderCredentialsException;
use pizzashop\shop\domain\service\catalogue\AuthProviderRefreshTokenException;
use pizzashop\shop\domain\service\catalogue\AuthServiceValidateException;
use pizzashop\shop\domain\service\catalogue\JwtManagerException;
use Psr\Log\LoggerInterface;

class AuthService implements AuthServiceInterface
{
    private AuthProvider $authProvider;
    private JwtManager $jwtManager;
    private LoggerInterface $logger;

    public function __construct(AuthProvider $authProvider, JwtManager $jwtManager, LoggerInterface $logger)
    {
        $this->authProvider = $authProvider;
        $this->jwtManager = $jwtManager;
        $this->logger = $logger;
    }

    public function signup(CredentialsDTO $credentialsDTO): UserDTO
    {
        try {
            $this->authProvider->register($credentialsDTO->email, $credentialsDTO->password);
        } catch (AuthProviderSignupException $e) {
            $this->logger->warning($e->getMessage());
            throw new AuthServiceSignupException($e->getMessage());
        }
    }

    public function signin(CredentialsDTO $credentialsDTO): TokenDTO
    {
        try {
            $this->authProvider->checkCredentials($credentialsDTO->email, $credentialsDTO->password);
        } catch (AuthProviderCredentialsException $e) {
            $this->logger->warning('auth attent failed for '.$credentialsDTO->email.' : '.$e->getMessage());
            throw new AuthServiceCredentialsException($e->getMessage());
        }
    }

    public function validate(TokenDTO $tokenDTO): UserDTO
    {
        try {
            $payload = $this->jwtManager->validate($tokenDTO->token);
        } catch (JwtManagerException $e) {
            throw new AuthServiceValidateException("Expired jwt token, try refreshing it");
        }

    }

    public function refresh(TokenDTO $tokenDTO): TokenDTO
    {
        try {
            $this->authProvider->checkToken($tokenDTO->refreshToken);
        } catch (AuthProviderRefreshTokenException $e) {
            $this->logger->warning("failed JWT refresh")
        }
    }

    public function activate_signup(TokenDTO $tokenDTO): void
    {

    }

    public function reset_password(TokenDTO $tokenDTO, CredentialsDTO $credentialsDTO): void
    {

    }
}