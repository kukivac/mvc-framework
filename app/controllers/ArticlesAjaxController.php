<?php

declare(strict_types=1);

namespace app\controllers;

use app\classes\exceptions\ArticlesException;
use app\models\ArticlesModel;
use Dibi\Exception;
use system\core\api\ApiResponse;
use system\core\controllers\DataController;
use system\core\user\User;

class ArticlesAjaxController extends DataController
{
    protected $articles_model;

    public function __construct(bool $active = true)
    {
        parent::__construct($active);
        $this->articles_model = new ArticlesModel();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function getContentCreateArticle()
    {
        if (count($_POST) > 0 && array_key_exists("title", $_POST) && array_key_exists("description", $_POST) && array_key_exists("content", $_POST)) {
            $title = htmlspecialchars($_POST["title"]);
            $description = htmlspecialchars($_POST["description"]);
            $content = htmlspecialchars($_POST["content"]);
            $user_id = $this->getLoggedInUserId();
            if ($user_id === null) {
                $response = new ApiResponse(["error" => "User must be logged in"], ApiResponse::HTTP_401_UNAUTHORIZED);
            } else {
                try {
                    $id = $this->articles_model->createNewArticle($title, $content, $description, $user_id);
                    $response = new ApiResponse(["data" => ["id" => $id]], ApiResponse::HTTP_200_OK);
                } catch (ArticlesException $exception) {
                    switch ($exception->getCode()) {
                        case ArticlesException::TITLE_ALREADY_EXISTS:
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
    public function getContentDeleteArticle(array $query)
    {
        if (array_key_exists("id", $query) && is_numeric($query["id"])) {
            if (!$this->isAdmin()) {
                $response = new ApiResponse(["error" => "User must be " . User::ROLE_ADMIN], ApiResponse::HTTP_401_UNAUTHORIZED);
            } else {
                $this->articles_model->deleteArticle(intval($query["id"]));
                $response = new ApiResponse(["data" => "Article was deleted"], ApiResponse::HTTP_200_OK);
            }
        } else {
            $response = new ApiResponse(["error" => "Bad request data"], ApiResponse::HTTP_400_BAD_REQUEST);
        }

        $this->setResponse($response);
    }
}