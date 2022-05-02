<?php

namespace App\Action\Recipe;

use App\Domain\Recipe\Service\RecipeService;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RecipeFetchAction
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
        
        $id = $request->getQueryParams()["id"];
            
        if(isset($id) && !empty($id)) {
            $recipe = $this->recipeService->getRecipeById($id);
            
            if(!$recipe) {
                $response->getBody()->write((string)json_encode(["error" => "Recipe not found"]));
                
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(404);
            }
            
            $response->getBody()->write((string)json_encode($recipe));

        } else {
            $recipe = $this->recipeService->getAllRecipes();

            // create api result structure number of data
            $result = [
                'count' => count($recipe),
                'results' => $recipe
            ];

            $response->getBody()->write((string)json_encode($result));
        }       
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
