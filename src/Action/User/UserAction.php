<?php


namespace App\Action\UserActions;


use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserAction
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

        $id = (int)$request->getAttributes()["id"];

        $users = null;

        if (isset($id) && !empty($id)){
            $users = $this->userService->getUser($id);
        }
        else{
            $options = $request->getQueryParams();

            $users = $this->userService->getUsers($options);
        }


        // Build the HTTP response
        $response->getBody()->write((string)json_encode($users));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}