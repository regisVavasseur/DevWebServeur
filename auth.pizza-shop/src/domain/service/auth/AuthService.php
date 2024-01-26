<?php

namespace pizzashop\auth\api\domain\service\auth;

use pizzashop\auth\api\domain\dto\CredentialsDTO;
use pizzashop\auth\api\domain\dto\TokenDTO;
use pizzashop\auth\api\domain\dto\UserDTO;
use pizzashop\auth\api\domain\entites\User;
use pizzashop\auth\api\domain\provider\AuthProvider;
use pizzashop\auth\api\domain\provider\AuthServiceCredentialsException;
use pizzashop\auth\api\domain\provider\JwtManager;
use Psr\Log\LoggerInterface;
use pizzashop\auth\api\domain\provider\AuthProviderCredentialsException;
use pizzashop\auth\api\domain\provider\JwtManagerExpiredTokenException;
use pizzashop\auth\api\domain\provider\JwtManagerInvalidTokenException;

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

    public function signup(CredentialsDTO $credentialsDTO): TokenDTO
    {
        $user = User::find($credentialsDTO->email);
        if (!is_null($user)) throw new AuthServiceCredentialsException("User already exists");

        $user = new User();
        $user->email = $credentialsDTO->email;
        $user->password = $this->authProvider->register($credentialsDTO->password);
        $user->save();

        // Récupération du token utilisateur en le connectant
        $this->authProvider->checkCredentials($user->email, $credentialsDTO->password);
        $user = $this->authProvider->getAuthenticatedUser(); // Assuming this returns an array of user data.
        $jwt = $this->jwtManager->create(['username' => $user['username'], 'email' => $user['email']]);

        return new TokenDTO($jwt, $user['refresh_token']);
    }

    public function signin(CredentialsDTO $credentialsDTO): TokenDTO
    {
        try {
            $this->authProvider->checkCredentials($credentialsDTO->email, $credentialsDTO->password);
            $user = $this->authProvider->getAuthenticatedUser(); // Assuming this returns an array of user data.
            $jwt = $this->jwtManager->create(['username' => $user['username'], 'email' => $user['email']]);
            return new TokenDTO($jwt, $user['refresh_token']);
        } catch (AuthProviderCredentialsException $e) {
            $this->logger->warning('Auth attempt failed for ' . $credentialsDTO->email . ' : ' . $e->getMessage());
            throw new AuthServiceCredentialsException($e->getMessage());
        }
    }

    public function validate(TokenDTO $tokenDTO): UserDTO
    {
        try {
            $payload = $this->jwtManager->validate($tokenDTO->token);
            return new UserDTO($payload);
        } catch (JwtManagerExpiredTokenException $e) {
            $this->logger->warning('JWT expired: ' . $e->getMessage());
            throw new AuthServiceValidateException('Expired jwt token, try refreshing it');
        } catch (JwtManagerInvalidTokenException $e) {
            $this->logger->warning('Invalid JWT: ' . $e->getMessage());
            throw new AuthServiceValidateException('Invalid jwt token');
        }
    }

    public function refresh(TokenDTO $tokenDTO): TokenDTO
    {
        try {
            $this->authProvider->checkRefreshToken($tokenDTO->refreshToken); // This method is now in line with earlier provided code.
            $user = $this->authProvider->getAuthenticatedUser(); // Assuming this returns an array of user data.
            $newJwt = $this->jwtManager->create(['username' => $user['username'], 'email' => $user['email']]);
            return new TokenDTO($newJwt, $user['refresh_token']);
        } catch (AuthProviderRefreshTokenException $e) {
            $this->logger->warning("Failed JWT refresh: " . $e->getMessage());
            throw new AuthServiceCredentialsException('Refresh token invalid or expired');
        }
    }

    public function activate_signup(TokenDTO $tokenDTO): void
    {
        // This feature is not yet implemented as per the exercise.
    }

    public function reset_password(TokenDTO $tokenDTO, CredentialsDTO $credentialsDTO): void
    {
        // This feature is not yet implemented as per the exercise.
    }
}