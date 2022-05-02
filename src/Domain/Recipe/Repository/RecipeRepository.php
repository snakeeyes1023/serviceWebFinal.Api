<?php

namespace App\Domain\Recipe\Repository;

use PDO;

/**
 * Repository.
 */
class RecipeRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Insert recipe row.
     *
     * @param array $recipe The recipe
     *
     * @return int The new ID
     */
    public function insertRecipe(array $recipe): int
    {
        $row = [
            'name' => $recipe['Name'],
            'recipe_type_id' => $recipe['RecipeTypeId'],
            'time_cook' => $recipe['TimeCook'],
            'time_prep' => $recipe['TimePrep'],
            'ingredients' => $recipe['Ingredients'],
            'instructions' => $recipe['Instructions'],
            'note' => $recipe['Note'],
            'tags' => $recipe['Tags'],
        ];

        $sql = "INSERT INTO recipe SET 
                Name=:name, 
                RecipeTypeId=:recipe_type_id, 
                TimeCook=:time_cook, 
                TimePrep=:time_prep, 
                Ingredients=:ingredients,
                Instructions=:instructions, 
                Note=:note, 
                Tags=:tags;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }

    /**
     * Update recipe row.
     * 
     * @param array $recipe The recipe
     * 
     * @return void
     */
    public function updateRecipe(array $recipe): void
    {
        $row = [
            'id' => $recipe['Id'],
            'name' => $recipe['Name'],
            'recipe_type_id' => $recipe['RecipeTypeId'],
            'time_cook' => $recipe['TimeCook'],
            'time_prep' => $recipe['TimePrep'],
            'instructions' => $recipe['Instructions'],
            'ingredients' => $recipe['Ingredients'],
            'note' => $recipe['Note'],
            'tags' => $recipe['Tags'],
        ];

        $sql = "UPDATE recipe SET 
                Name=:name, 
                RecipeTypeId=:recipe_type_id, 
                TimeCook=:time_cook, 
                TimePrep=:time_prep, 
                Instructions=:instructions, 
                Ingredients=:ingredients,
                Note=:note, 
                Tags=:tags 
                WHERE Id=:id;";
        
        $this->connection->prepare($sql)->execute($row);
    }

    /**
     * Get all recipes.
     *
     * @return array The recipes
     */
    public function getAllRecipes(): array
    {
        $sql = "SELECT recipe.Id, recipe.Name, recipetype.Name as TypeName, recipe.TimeCook, recipe.TimePrep, recipe.Instructions, recipe.Note, recipe.Tags, recipe.Ingredients FROM recipe INNER JOIN recipetype ON recipetype.Id = recipe.RecipeTypeId ;";

        $statement = $this->connection->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get recipe by ID.
     * 
     * @param int $id The ID
     * 
     */
    public function getRecipeById(int $id): array
    {
        $sql = "SELECT recipe.Id, recipe.Name, recipetype.Name as TypeName, recipe.TimeCook, recipe.TimePrep, recipe.Instructions, recipe.Ingredients, recipe.Note, recipe.Tags FROM recipe INNER JOIN recipetype ON recipetype.Id = recipe.RecipeTypeId WHERE recipe.Id = :id;";

        $statement = $this->connection->prepare($sql);

        $statement->execute(['id' => $id]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Delete Recipe
     * 
     * @param int $id The ID
     */
    public function deleteRecipe(int $id): void
    {
        $sql = "DELETE FROM recipe WHERE Id = :id;";

        $statement = $this->connection->prepare($sql);

        $statement->execute(['id' => $id]);
    }
}

