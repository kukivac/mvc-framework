<?php

declare(strict_types=1);

namespace app\controllers;

use app\classes\exceptions\NewsException;
use app\models\NewsModel;
use Dibi\Exception;
use system\core\api\ApiResponse;
use system\core\controllers\DataController;
use system\core\user\User;

class NewsAjaxController extends DataController
{
    protected $news_model;

    public function __construct(bool $active = true)
    {
        parent::__construct($active);
        $this->news_model = new NewsModel();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function getContentCreateNews()
    {
        if (count($_POST) > 0 && array_key_exists("title", $_POST) && array_key_exists("content", $_POST)) {
            $title = htmlspecialchars($_POST["title"]);
            $content = htmlspecialchars($_POST["content"]);
            if (!$this->isAdmin()) {
                $response = new ApiResponse(["error" => "User must be " . User::ROLE_ADMIN], ApiResponse::HTTP_401_UNAUTHORIZED);
            } else {
                try {
                    $id = $this->news_model->createNewNewsArticle($title, $content);
                    $response = new ApiResponse(["data" => ["id" => $id]], ApiResponse::HTTP_200_OK);
                } catch (NewsException $exception) {
                    switch ($exception->getCode()) {
                        case NewsException::TITLE_ALREADY_EXISTS:
                            $response = new ApiResponse(["error" => "Title already exists"], ApiResponse::HTTP_400_BAD_REQUEST);
                            break;
                        default:
                            $response = new ApiResponse(["error" => "Error occured"], ApiResponse::HTTP_500_SERVER_ERROR);
                            break;
                    }
                }
            }
        } else {
            $response = new ApiResponse(["error" => "Bad request data"], ApiResponse::HTTP_400_BAD_REQUEST);
        }
        $this->setResponse($response);
    }

    /**
     * @param array $query
     * @return void
     * @throws Exception
     */
    public function getContentDeleteNews(array $query)
    {
        if (array_key_exists("id", $query) && is_numeric($query["id"])) {
            if (!$this->isAdmin()) {
                $response = new ApiResponse(["error" => "User must be " . User::ROLE_ADMIN], ApiResponse::HTTP_401_UNAUTHORIZED);
            } else {
                $this->news_model->deleteNewsArticle(intval($query["id"]));
                $response = new ApiResponse(["data" => "News article was deleted"], ApiResponse::HTTP_200_OK);
            }
        } else {
            $response = new ApiResponse(["error" => "Bad request data"], ApiResponse::HTTP_400_BAD_REQUEST);
        }

        $this->setResponse($response);
    }
}