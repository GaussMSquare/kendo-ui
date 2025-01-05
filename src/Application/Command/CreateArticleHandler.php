<?php

namespace App\Application\Command;

use App\Domain\ArticleRepositoryInterface;
use App\Domain\Entity\Article;

class CreateArticleHandler
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function handle(array $params): array
    {
        $command = CreateArticleCommand::create($params);

        $article = new Article();
        $article->setTitle($command->getTitle());
        $article->setContent($command->getContent());

        return $this->articleRepository->create($article);
    }
}