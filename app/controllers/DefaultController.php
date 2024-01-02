<?php

namespace app\controllers;

use app\models\ArticlesModel;
use app\models\NewsModel;
use system\core\controllers\ViewController;

/**
 * Controller DefaultController
 *
 * @package app\controllers
 */
class DefaultController extends ViewController
{
    protected $articles_model;

    protected $news_model;

    public function __construct(bool $active = true)
    {
        parent::__construct($active);
        $this->articles_model = new ArticlesModel();
        $this->news_model = new NewsModel();
    }

    /**
     * @param mixed[] $query
     * @return void
     */
    public function getContentDefault(array $query): void
    {
        $news_articles = $this->news_model->getlist();
        $articles = $this->articles_model->getlist();
        $this->assign('title', "Homepage");
        $this->assign("news_articles", $news_articles);
        $this->assign("articles", $articles);
        $this->setView('default.default');
    }
}