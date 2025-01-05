<?php

declare(strict_types=1);

namespace App\Application\Command;

class DeleteArticleCommand
{
    private int $id;

    private function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function create(int $id): self
    {
        return new self($id);
    }

    public function getId(): int
    {
        return $this->id;
    }
}