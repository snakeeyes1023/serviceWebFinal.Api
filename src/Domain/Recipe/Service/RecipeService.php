<?php

namespace App\Domain\Recipe\Service;

use App\Domain\Recipe\Repository\RecipeRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class RecipeService
{
    /**
     * @var RecipeRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param RecipeRepository $repository The repository
     */
    public function __construct(RecipeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new recipe.
     * 
     * @param array $data The form data
     */
    public function createRecipe(array $data): bool
    {
        try {
            $this->validateNewRecipe($data);

            // Insert recipe
            $recipeId = $this->repository->insertRecipe($data);

            return $recipeId;
        } catch (ValidationException $e) {
            // Logging here: Validation error
            //$this->logger->error(sprintf('Validation error: %s', $e->getMessage()));
            return 0;
        }
    }

    /**
     * Update a recipe.
     * 
     * @param array $data The form data
     * 
     * @return bool
     */
    public function updateRecipe(array $data): bool
    {
        try {
            $this->validateNewRecipe($data);

            if (empty($data['id'] ?? 0)) {
                throw new ValidationException("Recipe ID is required");
            }

            // Update recipe
            $this->repository->updateRecipe($data);

            return true;
        } catch (ValidationException $e) {
            // Logging here: Validation error
            //$this->logger->error(sprintf('Validation error: %s', $e->getMessage()));
            return false;
        }
    }

    /**
     * Delete a recipe.
     * 
     * @param int $id The recipe ID
     */
    public function deleteRecipe(int $id): array
    {
        // create result structure
        try {
            if (empty($id)) {
                throw new ValidationException("Recipe ID is required");
            }

            // Delete recipe
            $this->repository->deleteRecipe($id);

        } catch (ValidationException $e) {
            
            $errorMessage = $e->getMessage();

            return [
                'success' => false,
                'message' =>  $errorMessage,
            ];
        }
    }

    /**
     * Get all recipes.
     * 
     * @return array
     */
    public function getAllRecipes(): array
    {
        return $this->repository->getAllRecipes();
    }

    // Get a recipe by ID
    public function getRecipeById(int $id): array
    {
        return $this->repository->getRecipeById($id);
    }


    /**
     * Input validation.
     *
     * @param array $data The form data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateNewRecipe(array $data): void
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        }

        if (empty($data['recipe_type_id'])) {
            $errors['recipe_type_id'] = 'Recipe type is required';
        }

        if (empty($data['time_cook'])) {
            $errors['time_cook'] = 'Time to cook is required';
        }

        if (empty($data['time_prep'])) {
            $errors['time_prep'] = 'Time to prep is required';
        }

        if (empty($data['instructions'])) {
            $errors['instructions'] = 'Instructions are required';
        }

        if (empty($data['note'])) {
            $errors['note'] = 'Note is required';
        }

        if (empty($data['tags'])) {
            $errors['tags'] = 'Tags are required';
        }

        if (!empty($errors)) {
            throw new ValidationException($errors . implode(', ', $errors));
        }
    }
}
