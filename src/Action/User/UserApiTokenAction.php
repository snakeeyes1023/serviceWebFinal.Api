<?php

namespace App\Action\UserActions;

use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserApiTokenAction
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        // Get all api tokens
        $apiTokens = $this->userService->getAllApiTokens();

        // Build reponse json result
        $response->getBody()->write(json_encode($apiTokens));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
