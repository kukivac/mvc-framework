<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\ArticlesModel;
use system\core\controllers\ViewController;
use system\core\Routes\Router;

class ArticlesController extends ViewController
{
    protected $articles_model;

    public function __construct(bool $active = true)
    {
        parent::__construct($active);
        $this->articles_model = new ArticlesModel();
    }

    public function getContentDefault(array $query)
    {
        if (array_key_exists("id", $query) && is_numeric($query["id"])) {
            $this->getContentNewsArticle(intval($query["id"]));
        } else {
            $articles = $this->articles_model->getlist();
            $this->assign("articles", $articles);
            $this->setView("articles.list");
        }
    }

    private function getContentNewsArticle(int $id)
    {
        $article = $this->articles_model->getArticle($id);
        $this->assign("article", $article);
        $this->setView("articles.article");
    }

    public function getContentCreateArticle()
    {
        if (!$this->isLoggedInUser()) {
            Router::reroute("articles");
        }
        $this->setView("articles.add");
    }
}