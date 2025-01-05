<?php

namespace App\Application\Command;

use App\Domain\ArticleRepositoryInterface;
use App\Domain\Entity\Article;

class UpdateArticleHandler
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function handle(int $id, array $params): array
    {
        $command = UpdateArticleCommand::create($id, $params);

        $article = new Article();
        $article->setId($command->getId());
        $article->setTitle($command->getTitle());
        $article->setContent($command->getContent());

        return $this->articleRepository->update($article);
    }
}