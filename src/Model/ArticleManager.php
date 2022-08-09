<?php

namespace App\Model;

class ArticleManager extends AbstractManager
{
    public const TABLE = 'article';

    /**
     * Insert new article in database
     */
    public function insert(array $article): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`) VALUES (:title)");
        $statement->bindValue('title', $article['title'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Update article in database
     */
    public function update(array $article): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $article['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $article['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }
    
}
