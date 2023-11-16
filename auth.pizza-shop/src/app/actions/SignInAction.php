<?php

namespace pizzashop\auth\api\app\actions;

use pizzashop\auth\api\domain\provider\AuthServiceCredentialsException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use pizzashop\auth\api\domain\dto\CredentialsDTO;
use pizzashop\auth\api\domain\service\auth\AuthService;

class SignInAction
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $params = json_decode((string) $request->getBody(), true) ?? [];

        $email = $params['email'] ?? null;
        $password = $params['password'] ?? null;

        if (null === $email || null === $password) {
            $response->getBody()->write(json_encode(['error' => 'Missing email or password']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        try {
            $credentials = new CredentialsDTO($params['email'], $params['password']);
            $tokenDTO = $this->authService->signin($credentials);

            // Encode token DTO to JSON
            $response->getBody()->write(json_encode($tokenDTO));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (AuthServiceCredentialsException $e) {
            // Handle invalid credentials
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }
    }
}