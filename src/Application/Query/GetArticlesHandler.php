<?php

namespace App\Application\Query;

use App\Domain\ArticleRepositoryInterface;

class GetArticlesHandler
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function handle(int $page, int $pageSize): array
    {
        return $this->articleRepository->getAll($page, $pageSize);
    }
}