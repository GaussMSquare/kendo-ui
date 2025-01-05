<?php

namespace App\Tests\Unit\Infrastructure\Repository;

use App\Domain\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArticleRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testCreateArticle()
    {
        $article = new Article();
        $article->setTitle('Test Article');
        $article->setContent('This is a test article.');

        $this->entityManager->persist($article);
        $this->entityManager->flush();

        $this->assertNotNull($article->getId());
    }

    public function testUpdateArticle()
    {
        $article = $this->entityManager->getRepository(Article::class)->findOneBy(['title' => 'Test Article']);
        $this->assertNotNull($article);

        $article->setContent('Updated content');
        $this->entityManager->flush();

        $updatedArticle = $this->entityManager->getRepository(Article::class)->findOneBy(['id' => $article->getId()]);
        $this->assertEquals('Updated content', $updatedArticle->getContent());
    }

    public function testListArticles()
    {
        $articles = $this->entityManager->getRepository(Article::class)->findAll();
        $this->assertNotEmpty($articles);
    }

    public function testDeleteArticle()
    {
        $article = $this->entityManager->getRepository(Article::class)->findOneBy(['title' => 'Test Article']);
        $id = $article->getId();
        $this->assertNotNull($article);

        $this->entityManager->remove($article);
        $this->entityManager->flush();

        $deletedArticle = $this->entityManager->getRepository(Article::class)->find($id);
        $this->assertNull($deletedArticle);
    }
}