<?php

namespace App\Action\RecipeType;

use App\Domain\RecipeType\Service\RecipeTypeService;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RecipeTypeFetchAction
{
    private $recipeTypeService;

    public function __construct(RecipeTypeService $recipeTypeService)
    {
        $this->recipeTypeService = $recipeTypeService;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {

        $recipeType = $this->recipeTypeService->getRecipeType();

        // create api result structure number of data
        $result = [
            'count' => count($recipeType),
            'results' => $recipeType
        ];

        $response->getBody()->write((string)json_encode($result));


        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
