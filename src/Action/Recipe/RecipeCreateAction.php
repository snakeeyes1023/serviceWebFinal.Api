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

        $result = [
            'success' => false,
            'message' => '',
        ];
        
        $recipeId = $this->recipeService->createRecipe($data);
        // Invoke the Domain with inputs and retain the result

        if($recipeId != 0){
            $result = [
                'recipe_id' => $recipeId,
                'result' => 'success',
                'message' => 'Recipe created!',
            ];
        }

        $response->getBody()->write((string)json_encode($result));
              
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
