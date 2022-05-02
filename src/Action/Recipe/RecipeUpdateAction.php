<?php

namespace App\Action\Recipe;

use App\Domain\Recipe\Service\RecipeService;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RecipeUpdateAction
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

        $id = (int)$request->getAttributes()["id"];
        $data["Id"] = $id;

        $result = $this->recipeService->updateRecipe($data);

        $response->getBody()->write((string)json_encode($result));
              
        $responseCode = 200;

        if(!(bool)$result["success"]) {
            $responseCode = 500;
        }
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($responseCode);
    }
}
