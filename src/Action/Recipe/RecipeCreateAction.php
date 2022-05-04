<?php

namespace App\Action\Recipe;

use App\Domain\Recipe\Service\RecipeService;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RecipeCreateAction
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
        
        $data = (array)$request->getParsedBody();
        $responseCode = 201;

        $creationResponse = $this->recipeService->createRecipe($data);

        if(!(bool)$creationResponse["success"]) {
            $responseCode = 500;
        }

        $response->getBody()->write((string)json_encode($creationResponse));
              
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($responseCode);
    }
}
