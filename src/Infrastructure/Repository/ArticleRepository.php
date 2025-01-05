<?php

namespace App\Infrastructure\Repository;

use App\Domain\ArticleRepositoryInterface;
use App\Domain\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository implements ArticleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getAll(int $page, int $pageSize): array
    {
        $queryBuilder = $this->createQueryBuilder('a');
        $total = (clone $queryBuilder)->select('COUNT(a.id)')->getQuery()->getSingleScalarResult();

        $articles = $queryBuilder
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize)
            ->getQuery()
            ->getResult();

        // Formater les données pour Kendo UI
        $data = array_map(fn($article) => [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
        ], $articles);

        return [
            'data' => $data,
            'total' => $total,
        ];
    }

    public function findById(int $id): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function create(Article $article): array
    {
        $this->getEntityManager()->persist($article);
        $this->getEntityManager()->flush();

        return [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        ];
    }

    /**
     * @throws \Exception
     */
    public function update(Article $article): array
    {
        $currentArticle = $this->findById($article->getId());

        if (!$currentArticle) {
            throw new \Exception('Article not found');
        }

        $currentArticle->setTitle($article->getTitle());
        $currentArticle->setContent($article->getContent());

        $this->getEntityManager()->persist($currentArticle);
        $this->getEntityManager()->flush();

        return [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        ];
    }

    public function delete(int $id): void
    {
        $article = $this->findById($id);
        $this->getEntityManager()->remove($article);
        $this->getEntityManager()->flush();
    }
}
