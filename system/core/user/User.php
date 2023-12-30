<?php

declare(strict_types=1);

namespace system\core\user;

class User
{
    /** @var int|null */
    private $id;

    /** @var string */
    private $username;

    /** @var string */
    private $firstname;

    /** @var string */
    private $lastname;

    /** @var string */
    private $email;

    /** @var UserLevel */
    private $user_level;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getUserLevel(): UserLevel
    {
        return $this->user_level;
    }

    public function setUserLevel(UserLevel $user_level): void
    {
        $this->user_level = $user_level;
    }
}