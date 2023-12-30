<?php

declare(strict_types=1);

namespace app\classes\structures;

class LoginStructure
{
    /** @var string */
    public $username;

    /** @var string */
    public $password;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}