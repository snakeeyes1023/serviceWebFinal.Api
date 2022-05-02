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
    public function createRecipe(array $data): array
    {
        // result
        $result = [
            'success' => false,
            'message' => '',
            'createId' => 0
        ];


        try {
            $this->validateNewRecipe($data);

            $data["Tags"] ?? "";
            $data["Note"] ?? "";

            // Insert recipe
            $recipeId = $this->repository->insertRecipe($data);

            // Set result
            $result['success'] = true;
            $result['message'] = 'Recipe created';
            $result['createId'] = $recipeId;

            return $result;
        } catch (ValidationException $e) {

            $result['message'] = $e->getMessage();

            // Logging here: Validation error
            //$this->logger->error(sprintf('Validation error: %s', $e->getMessage()));
            return $result;
        }
    }

    /**
     * Update a recipe.
     * 
     * @param array $data The form data
     * 
     * @return array
     */
    public function updateRecipe(array $data): array
    {
        $result = [
            'success' => false,
            'message' => ''
        ];

        try {

            $data["Tags"] ?? "";
            $data["Note"] ?? "";
            
            $this->validateNewRecipe($data);

            if (empty($data['Id'] ?? 0)) {
                throw new ValidationException("Recipe ID is required");
            }

            // Update recipe
            $this->repository->updateRecipe($data);

            // Set result
            $result['success'] = true;
            $result['message'] = 'Recipe updated';

            return $result;
        } catch (ValidationException $e) {

            $result['message'] = $e->getMessage();
            // Logging here: Validation error
            //$this->logger->error(sprintf('Validation error: %s', $e->getMessage()));
            return $result;
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

            // Set result
            $result = [
                'success' => true,
                'message' => 'Recipe deleted'
            ];
            return $result;

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

        if (empty($data['Name'])) {
            $errors['name'] = 'Name is required';
        }

        if (empty($data['RecipeTypeId'])) {
            $errors['RecipeTypeId'] = 'Recipe type is required';
        }

        if (empty($data['TimeCook'])) {
            $errors['TimeCook'] = 'Time to cook is required';
        }

        if (empty($data['TimePrep'])) {
            $errors['TimePrep'] = 'Time to prep is required';
        }

        if (empty($data['Ingredients'])) {
            $errors['Ingredients'] = 'Ingredients is required';
        }

        if (empty($data['Instructions'])) {
            $errors['Instructions'] = 'Instructions are required';
        }

        if (!empty($errors)) {
            throw new ValidationException($data. implode(', ', $data));

            //throw new ValidationException($errors . implode(', ', $errors));
        }
    }
}
