<?php

namespace App\Domain;

use App\Domain\Entity\Article;

interface ArticleRepositoryInterface
{
    public function getAll(int $page, int $pageSize): array;
    public function findById(int $id): ?Article;
    public function create(Article $article): array;
    public function update(Article $article): array;
    public function delete(int $id): void;
}