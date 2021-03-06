<?php

namespace App\Action\Recipe;

use App\Domain\Recipe\Service\RecipeService;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RecipeDeleteAction
{
    private $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {

        // Collect input from the HTTP request
        $id = (int)$request->getAttributes()["id"];

        // Invoke the Domain with inputs and retain the result
        $result = $this->recipeService->deleteRecipe($id);

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        $responseCode = 200;

        if(!(bool)$result["success"]) {
            $responseCode = 204;
        }


        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($responseCode);
    }
}
