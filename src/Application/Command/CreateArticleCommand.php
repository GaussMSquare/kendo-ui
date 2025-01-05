<?php

namespace App\Application\Command;

class CreateArticleCommand
{
    private string $title;
    private string $content;

    public function __construct(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    public static function create(array $params): self
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

        return new self($params['title'], $params['content']);
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