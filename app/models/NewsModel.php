<?php

declare(strict_types=1);

namespace app\models;

use app\classes\structures\NewsStructure;
use Dibi\Exception;
use Dibi\Result;
use system\core\model\Model;

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
        return reset($article);
    }

    /**
     * @return Result
     * @throws Exception
     */
    public function getlist(): Result
    {
        $query = $this->getDatabaseConnection()->query("SELECT * FROM news ORDER BY created_at");

        return $query->setRowFactory(function ($row) {
            return new NewsStructure($row);
        });
    }
}