<?php

namespace pizzashop\auth\api\app\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use pizzashop\auth\api\domain\dto\TokenDTO;
use pizzashop\auth\api\domain\service\auth\AuthService;
use pizzashop\auth\api\domain\service\auth\AuthServiceValidateException;

class ValidateTokenAction
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $tokenHeader = $request->getHeaderLine('Authorization');
        $token = !empty($tokenHeader) ? trim(str_replace('Bearer', '', $tokenHeader)) : '';

        try {
            $tokenDTO = new TokenDTO($token, '');
            $userDTO = $this->authService->validate($tokenDTO);

            // Encode user DTO to JSON
            $response->getBody()->write(json_encode($userDTO));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (AuthServiceValidateException $e) {
            // Handle invalid or expired token
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }
    }
}