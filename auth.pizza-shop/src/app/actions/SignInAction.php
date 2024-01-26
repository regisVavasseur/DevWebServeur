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
        //les credentials sont transportés dans le header
        //Authorization en mode Basic. En cas d'échec de l'authentification une réponse 401 avec un
        //message d'erreur dans un objet JSON et retournée. En cas de succès, une réponse 200 avec
        //le couple (access token, refresh token) dans un objet JSON est retournée.

        //récupérer les credentials depuis le header
        $tokenHeader = $request->getHeaderLine('Authorization');
        $credentials = !empty($tokenHeader) ? trim(str_replace('Basic', '', $tokenHeader)) : '';

        //decode base64
        $credentials = base64_decode($credentials);

        //séparer les credentials en email et password
        $email = substr($credentials, 0, strpos($credentials, ':'));
        $password = substr($credentials, strpos($credentials, ':') + 1);

        if (null === $email || null === $password) {
            $response->getBody()->write(json_encode(['error' => 'Missing email or password']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        try {
            $credentials = new CredentialsDTO($email, $password);
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