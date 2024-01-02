<?php

declare(strict_types=1);

namespace app\models;

use app\classes\structures\ArticleStructure;
use Dibi\Exception;
use Dibi\Result;
use system\core\model\Model;

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
        return reset($article);
    }

    /**
     * @return Result
     * @throws Exception
     */
    public function getlist(): Result
    {
        $query = $this->getDatabaseConnection()->query("SELECT * FROM articles ORDER BY created_at");

        return $query->setRowFactory(function ($row) {
            return new ArticleStructure($row);
        });
    }
}