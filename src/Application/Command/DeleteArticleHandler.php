<?php

namespace App\Application\Command;

use App\Domain\ArticleRepositoryInterface;

class DeleteArticleHandler
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function handle(int $id): void
    {
        $command = DeleteArticleCommand::create($id);

        $this->articleRepository->delete($command->getId());
    }
}