<?php

namespace pizzashop\auth\api\app\actions;

use pizzashop\auth\api\domain\provider\AuthServiceCredentialsException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use pizzashop\auth\api\domain\dto\TokenDTO;
use pizzashop\auth\api\domain\service\auth\AuthService;

class RefreshTokenAction
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $tokenHeader = $request->getHeaderLine('Authorization');
        $refreshToken = !empty($tokenHeader) ? trim(str_replace('Bearer', '', $tokenHeader)) : '';

        try {
            $tokenDTO = new TokenDTO('', $refreshToken);
            $newTokenDTO = $this->authService->refresh($tokenDTO);

            // Encode new token DTO to JSON
            $response->getBody()->write(json_encode($newTokenDTO));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (AuthServiceCredentialsException $e) {
            // Handle invalid or expired refresh token
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }
    }
}