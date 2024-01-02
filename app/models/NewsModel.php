<?php

declare(strict_types=1);

namespace app\models;

use app\classes\exceptions\NewsException;
use app\classes\structures\NewsStructure;
use Dibi\Exception;
use Dibi\Result;
use system\core\model\Model;
use system\core\Routes\Router;

class NewsModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param int $id
     * @return NewsStructure
     * @throws Exception
     */
    public function getNewsArticle(int $id): NewsStructure
    {
        $query = $this->getDatabaseConnection()->query("SELECT * FROM news WHERE id = %i", $id);
        $article = $query->setRowFactory(function ($row) {
            return new NewsStructure($row);
        })->fetchAll();

        $article = reset($article);
        if (!$article instanceof NewsStructure) {
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
            $query = $this->getDatabaseConnection()->query("SELECT * FROM news ORDER BY created_at LIMIT %i", $limit);
        } else {
            $query = $this->getDatabaseConnection()->query("SELECT * FROM news ORDER BY created_at");
        }

        return $query->setRowFactory(function ($row) {
            return new NewsStructure($row);
        });
    }

    /**
     * @param string $title
     * @return bool
     * @throws Exception
     */
    public function newsArticleExists(string $title): bool
    {
        $result = $this->getDatabaseConnection()->query("SELECT * FROM news WHERE title = %s", $title);

        return $result->count() === 1;
    }

    /**
     * @param string $title
     * @param string $content
     * @return int
     * @throws Exception
     * @throws NewsException
     */
    public function createNewNewsArticle(string $title, string $content)
    {
        $existing_title = $this->newsArticleExists($title);
        if ($existing_title) {
            throw new NewsException("News title already exists", NewsException::TITLE_ALREADY_EXISTS);
        }
        $query = $this->getDatabaseConnection()->translate("INSERT INTO news(title,content) VALUES (%s,%s)", $title, $content);
        $this->getDatabaseConnection()->query($query);

        return $this->getDatabaseConnection()->getInsertId();
    }

    /**
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function deleteNewsArticle(int $id)
    {
        $this->getDatabaseConnection()->query("DELETE FROM news WHERE id = %i", $id);
    }
}