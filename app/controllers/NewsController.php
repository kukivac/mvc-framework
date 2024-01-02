<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\NewsModel;
use system\core\controllers\ViewController;
use system\core\Routes\Router;

class NewsController extends ViewController
{
    protected $news_model;

    public function __construct(bool $active = true)
    {
        parent::__construct($active);
        $this->news_model = new NewsModel();
    }

    public function getContentDefault(array $query)
    {
        if (array_key_exists("id", $query) && is_numeric($query["id"])) {
            $this->getContentNewsArticle(intval($query["id"]));
        } else {
            $news_articles = $this->news_model->getlist();
            $this->assign("news_articles", $news_articles);
            $this->setView("news.list");
        }
    }

    private function getContentNewsArticle(int $id)
    {
        $news_article = $this->news_model->getNewsArticle($id);
        $this->assign("news_article", $news_article);
        $this->setView("news.article");
    }

    public function getContentCreateNewsArticle(array $query)
    {
        if (!$this->isAdmin()) {
            Router::reroute("news");
        }
        $this->setView("news.add");
    }
}