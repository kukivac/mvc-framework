<?php

declare(strict_types=1);

namespace app\models;

use app\classes\exceptions\UserException;
use Dibi\Exception;
use system\core\model\Model;
use system\core\user\User;
use system\core\user\UserLevel;

class UserModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param string $username
     * @param string $password
     * @return void
     * @throws \Exception
     * @throws UserException
     */
    public function checkUsersPassword(string $username, string $password): void
    {
        if (!$this->checkUserExistsByUsername($username)) {
            throw new UserException("User does not exist", UserException::USER_NOT_FOUND);
        }
        $result = $this->getDatabaseConnection()->query("SELECT password FROM users WHERE username = %s", $username);
        $database_password = $result->fetch()['password'];
        if (password_verify($password, $database_password)) {
            return;
        } else {
            throw new UserException("Password does not match", UserException::PASSWORD_NOT_MATCH);
        }
    }

    /**
     * @param string $username
     * @return bool
     * @throws Exception
     */
    private function checkUserExistsByUsername(string $username): bool
    {
        $result = $this->getDatabaseConnection()->query("SELECT * FROM users WHERE username = %s", $username);

        return $result->count() === 1;
    }

    /**
     * @param string $username
     * @return User
     * @throws Exception
     */
    public function getUserForSession(string $username): User
    {
        $user = new User();
        $user_level = new UserLevel();
        $db_user = $this->getDatabaseConnection()->query("SELECT u.id AS user_id, u.username, u.firstname, u.lastname, u.email, ul.id AS userlevel_id, ul.name FROM users u LEFT JOIN userlevel ul ON u.userlevel_id = ul.id WHERE u.username = %s", $username);
        $db_user = $db_user->fetch();
        $user->setId($db_user["user_id"]);
        $user->setUsername($db_user["username"]);
        $user->setFirstname($db_user["firstname"]);
        $user->setLastname($db_user["lastname"]);
        $user->setEmail($db_user["email"]);
        $user_level->setId($db_user["userlevel_id"]);
        $user_level->setName($db_user["name"]);
        $user->setUserLevel($user_level);

        return $user;
    }
}