<?php

namespace App\Domain\RecipeType\Repository;

use PDO;

/**
 * Repository.
 */
class RecipeTypeRepository
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
     * Get user by ID.
     *
     * @param int $userId The user ID
     *
     * @return array The user
     */    
    public function getRecipeType()
    {
        $sql = "SELECT * FROM recipetype;";

        $statement =  $this->connection->query($sql);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}

