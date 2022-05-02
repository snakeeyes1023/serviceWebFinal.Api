<?php

namespace App\Domain\User\Repository;

use PDO;

/**
 * Repository.
 */
class UserRepository
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
     * Validate user token
     * 
     * @param string $token The user token
     * 
     * @return bool True if the token is valid
     */
    public function validateToken($token) : bool
    {
        $sql = "SELECT Id FROM apikey WHERE Token = :token;";

        $statement =  $this->connection->prepare($sql);
        $statement->bindParam(':token', $token);
        $statement->execute();

        return $statement->rowCount() > 0;
    }
}

