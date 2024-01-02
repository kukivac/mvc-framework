<?php

declare(strict_types=1);

namespace app\classes\structures;

use Dibi\DateTime;

class NewsStructure
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $content;

    /** @var DateTime */
    private $created_at;

    /**
     * @param array $row
     */
    public function __construct(array $row)
    {
        $this->id = intval($row["id"]);
        $this->title = $row["title"];
        $this->content = $row["content"];
        $this->created_at = $row["created_at"];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed|string $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed|string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed|string $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return DateTime|mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param DateTime|mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }
}