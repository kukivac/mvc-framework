<?php

declare(strict_types=1);

namespace app\models;

use app\classes\exceptions\ArticlesException;
use app\classes\structures\ArticleStructure;
use Dibi\Exception;
use Dibi\Result;
use system\core\model\Model;
use system\core\routes\Router;

class ArticlesModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param int $id
     * @return ArticleStructure
     * @throws Exception
     */
    public function getArticle(int $id): ArticleStructure
    {
        $query = $this->getDatabaseConnection()->query("SELECT * FROM articles WHERE id = %i", $id);
        $article = $query->setRowFactory(function ($row) {
            return new ArticleStructure($row);
        })->fetchAll();

        $article = reset($article);
        if (!$article instanceof ArticleStructure) {
            Router::reroute("news");
        } else {
            return $article;
        }
    }

    /**
     * @param int|null $limit
     * @return Result
     * @throws Exception
     */
    public function getlist(?int $limit = null): Result
    {
        if ($limit !== null) {
            $query = $this->getDatabaseConnection()->query("SELECT * FROM articles ORDER BY created_at LIMIT %i", $limit);
        } else {
            $query = $this->getDatabaseConnection()->query("SELECT * FROM articles ORDER BY created_at");
        }
        return $query->setRowFactory(function ($row) {
            return new ArticleStructure($row);
        });
    }

    /**
     * @param string $title
     * @return bool
     * @throws Exception
     */
    public function articleExists(string $title): bool
    {
        $result = $this->getDatabaseConnection()->query("SELECT * FROM articles WHERE title = %s", $title);

        return $result->count() === 1;
    }

    /**
     * @param string $title
     * @param string $content
     * @param string $description
     * @param int $user_id
     * @return int
     * @throws ArticlesException
     * @throws Exception
     */
    public function createNewArticle(string $title, string $content, string $description, int $user_id)
    {
        $existing_title = $this->articleExists($title);
        if ($existing_title) {
            throw new ArticlesException("News title already exists", ArticlesException::TITLE_ALREADY_EXISTS);
        }
        $query = $this->getDatabaseConnection()->translate("INSERT INTO articles(title,content,description,author) VALUES (%s,%s,%s,%i)", $title, $content, $description, $user_id);
        $this->getDatabaseConnection()->query($query);

        return $this->getDatabaseConnection()->getInsertId();
    }

    /**
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function deleteArticle(int $id)
    {
        $this->getDatabaseConnection()->query("DELETE FROM articles WHERE id = %i", $id);
    }
}