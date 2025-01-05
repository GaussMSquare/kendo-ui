<?php

namespace App\Application\Command;

class UpdateArticleCommand
{
    private int $id;
    private string $title;
    private string $content;

    public function __construct(int $id, string $title, string $content)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
    }

    public static function create(int $id, array $params): self
    {
        if (!isset($params['title'])) {
            throw new \InvalidArgumentException('title not provided');
        }

        if (strlen($params['title']) > 255) {
            throw new \InvalidArgumentException('title is too long');
        }

        if (!isset($params['content'])) {
            throw new \InvalidArgumentException('content not provided');
        }

        return new self($id, $params['title'], $params['content']);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}