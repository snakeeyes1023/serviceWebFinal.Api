<?php

namespace App\Domain\RecipeType\Service;

use App\Domain\RecipeType\Repository\RecipeTypeRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class RecipeTypeService
{
    /**
     * @var RecipeTypeRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param RecipeTypeRepository $repository The repository
     */
    public function __construct(RecipeTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Update a recipe.
     * 
     * @return array
     */
    public function getRecipeType(): array
    {
        return $this->repository->getRecipeType();
    }
}
