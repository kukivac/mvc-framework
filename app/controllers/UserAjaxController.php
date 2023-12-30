<?php

declare(strict_types=1);

namespace app\controllers;

use app\classes\exceptions\UserException;
use app\models\UserModel;
use system\core\api\ApiResponse;
use system\core\controllers\DataController;

class UserAjaxController extends DataController
{
    /** @var UserModel */
    private $user_model;

    public function __construct()
    {
        parent::__construct();
        $this->user_model = new UserModel();
    }

    public function getContentLogin()
    {
        if (count($_POST) > 0 && array_key_exists('username', $_POST) && array_key_exists('password', $_POST)) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            try {
                $this->user_model->checkUsersPassword($username, $password);
                $response = new ApiResponse(["data" => "Successfull login"]);
                $this->setLoggedInUser($this->user_model->getUserForSession($username), true);
            } catch (UserException $exception) {
                switch ($exception->getCode()) {
                    case UserException::USER_NOT_FOUND:
                        $response = new ApiResponse(["error" => "User not found"], ApiResponse::HTTP_404_NOT_FOUND);
                        break;
                    case UserException::PASSWORD_NOT_MATCH:
                        $response = new ApiResponse(["error" => "Password does not match"], ApiResponse::HTTP_401_UNAUTHORIZED);
                        break;
                    default:
                        $response = new ApiResponse(["error" => "Error occured"], ApiResponse::HTTP_500_SERVER_ERROR);
                        break;
                }
            } catch (\Exception $e) {
                $response = new ApiResponse(["error" => "Error occured"], ApiResponse::HTTP_500_SERVER_ERROR);
            }
        } else {
            $response = new ApiResponse(["error" => "Bad request data"], ApiResponse::HTTP_400_BAD_REQUEST);
        }
        $this->setResponse($response);
    }
}