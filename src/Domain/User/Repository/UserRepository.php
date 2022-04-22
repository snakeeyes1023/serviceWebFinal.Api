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
     * Insert user row.
     *
     * @param array $user The user
     *
     * @return int The new ID
     */
    public function insertUser(array $user): int
    {
        $row = [
            'username' => $user['username'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'password' => $user['password'],
        ];

        $sql = "INSERT INTO users SET 
                username=:username, 
                first_name=:first_name, 
                last_name=:last_name, 
                password=:password, 
                email=:email;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }

    /**
     * Get user by username.
     *
     * @param int $usename The username
     *
     * @return array The user
     */
    public function getUserByUsername($username)
    {
        $params = ["username" => $username];

        $sql = "SELECT * FROM users WHERE username=:username";

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if($result.length === 0) {
            return null;
        }
        
        return $result[0];
    }


    /**
     * Get user by ID.
     *
     * @param int $userId The user ID
     *
     * @return array The user
     */    
    public function getUsers($order)
    {
        $sql = "SELECT * FROM Users order by username $order;";

        $statement =  $this->connection->query($sql);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Validate user token
     * 
     * @param string $token The user token
     * 
     * @return bool True if the token is valid
     */
    public function validateToken($token)
    {
        // check token empty or null
        if (empty($token)) {
            return false;
        }
        
        $params = ["token" => $token];

        $sql = "SELECT * FROM cle_api WHERE no_cle = :token";

        $query = $this->connection->prepare($sql);
        $query->execute($params);
        
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        //check if result is empty
        if($result[0] == null || empty($result[0]["user_id"])) {
            return false;
        }

        return true;
    }
    /**
     * Get user by ID.
     *
     * @param int $userId The user ID
     *
     * @return array The user
     */
    public function getUser($id)
    {
        $sql = "SELECT * FROM Users WHERE id = $id;";

        $statement =  $this->connection->query($sql);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /***
     * edit user
     * @param array $user
     * @return int
     */
    public function editUser(array $user, $id)
    {
        $row = [
            "id"=> $id,
            'username' => $user['username'] ?? "TEST",
            'first_name' => $user['first_name'] ?? "TEST",
            'last_name' => $user['last_name'] ?? "TEST",
            'email' => $user['email'] ?? "TEST",
        ];

        $sql = "UPDATE users SET 
                username=:username, 
                first_name=:first_name, 
                last_name=:last_name, 
                email=:email WHERE id =:id;";

        $this->connection->prepare($sql)->execute($row);

        return $this->getUser($id);
    }

    /**
     * Delete user by ID.
     *
     * @param int $userId The user ID
     */
    public function deleteUser(int $id)
    {
        $sql = "DELETE users WHERE id = $id;";

        $this->connection->prepare($sql)->execute();

        $result = [
            'resultat' => "true"
        ];

        return $result;
    }

    /**
     * Delete all api token by user ID.
     * 
     * @param int $userId The user ID
     */
    public function deleteApiToken(int $userId)
    {
        $row = [
            "userId"=> $userId
        ];

        $sql = "DELETE FROM cle_api WHERE user_id=:userId;";

        $this->connection->prepare($sql)->execute($row);
    }

    /**
     * Create an api token
     *
     * @param int $id The user ID
     * @param string $apiToken The api token
     *
     */
    public function createApiToken(int $id, string $apiToken)
    {     
        $this->deleteApiToken($id);

        $row = [
            "user_id"=> $id ?? 1,
            'no_cle' => $apiToken ?? ""    
        ];

        $sql = "INSERT INTO cle_api SET user_id=:user_id, no_cle=:no_cle;";

        $this->connection->prepare($sql)->execute($row);
    }


    /**
     * Get user by api token.
     *
     *
     */
    public function getAllApiTokens()
    {
        $sql = "SELECT * FROM cle_api;";

        $statement =  $this->connection->query($sql);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}

