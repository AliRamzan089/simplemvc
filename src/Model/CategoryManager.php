<?php

namespace App\Model;

class CategoryManager extends AbstractManager
{
    public const TABLE = 'category';

    /**
     * Insert new category in database
     */
    public function insert(array $category): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`) VALUES (:title)");
        $statement->bindValue('title', $category['title'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Update category in database
     */
    public function update(array $category): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $category['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $category['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
