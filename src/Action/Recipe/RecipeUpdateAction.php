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

        $result = [
            'success' => false,
            'message' => '',
        ];
        
        // Invoke the Domain with inputs and retain the result
        if($this->recipeService->updateRecipe($data)){
            $result = [
                'result' => 'success',
                'message' => 'User updated!',
            ];
        }

        $response->getBody()->write((string)json_encode($result));
              
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
