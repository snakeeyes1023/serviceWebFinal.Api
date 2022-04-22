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
            'name' => $recipe['name'],
            'recipe_type_id' => $recipe['recipe_type_id'],
            'time_cook' => $recipe['time_cook'],
            'time_prep' => $recipe['time_prep'],
            'instructions' => $recipe['instructions'],
            'note' => $recipe['note'],
            'tags' => $recipe['tags'],
        ];

        $sql = "INSERT INTO recipe SET 
                name=:name, 
                recipe_type_id=:recipe_type_id, 
                time_cook=:time_cook, 
                time_prep=:time_prep, 
                instructions=:instructions, 
                note=:note, 
                tags=:tags;";

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
            'id' => $recipe['id'],
            'name' => $recipe['name'],
            'recipe_type_id' => $recipe['recipe_type_id'],
            'time_cook' => $recipe['time_cook'],
            'time_prep' => $recipe['time_prep'],
            'instructions' => $recipe['instructions'],
            'note' => $recipe['note'],
            'tags' => $recipe['tags'],
        ];

        $sql = "UPDATE recipe SET 
                name=:name, 
                recipe_type_id=:recipe_type_id, 
                time_cook=:time_cook, 
                time_prep=:time_prep, 
                instructions=:instructions, 
                note=:note, 
                tags=:tags 
                WHERE id=:id;";

        $this->connection->prepare($sql)->execute($row);
    }

    /**
     * Get all recipes.
     *
     * @return array The recipes
     */
    public function getAllRecipes(): array
    {
        $sql = "SELECT recipe.Id, recipe.Name, recipetype.Name as TypeName, recipe.TimeCook, recipe.TimePrep, recipe.Instructions, recipe.Note, recipe.Tags FROM recipe INNER JOIN recipetype ON recipetype.Id = recipe.RecipeTypeId ;";

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
        $sql = "SELECT recipe.Id, recipe.Name, recipetype.Name as TypeName, recipe.TimeCook, recipe.TimePrep, recipe.Instructions, recipe.Note, recipe.Tags FROM recipe INNER JOIN recipetype ON recipetype.Id = recipe.RecipeTypeId WHERE recipe.Id = :id;";

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

