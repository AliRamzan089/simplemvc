<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function search(string $email)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE email=:email");
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetchObject();
        if ($user) {
            return $user;
        }
        return false;
    }

    /**
     * Insert new user in database
     */
    public function insert(array $user): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (firstname, lastname, email, password) 
        VALUES (:firstname, :lastname, :email, :password)");
        $statement->bindValue('firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Update user in database
     */
    public function update(array $user): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `firstname`=:firstname, `lastname`=:lastname, 
        `email`=:email,
         WHERE id=:id");
        $statement->bindValue('id', $user['id'], \PDO::PARAM_INT);
        $statement->bindValue('firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
