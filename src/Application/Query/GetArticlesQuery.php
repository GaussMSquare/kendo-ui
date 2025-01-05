<?php

declare(strict_types=1);

namespace App\Application\Query;


class GetArticlesQuery
{
    private string $title;
    private string $content;

    private function __construct(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    public static function create(string $title, string $content): self
    {
        return new self($title, $content);
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