<?php

namespace App\Application\Controller;

use App\Application\Query\GetArticlesHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GetArticlesController extends AbstractController
{
    #[Route('/articles', name: 'article_index')]
    public function index()
    {
        return $this->render('articles/index.html.twig');
    }

    #[Route('/api/articles', name: 'find_articles_api')]
    public function api(Request $request, GetArticlesHandler $handler): JsonResponse
    {
        $page = $request->query->getInt("page", 1);
        $pageSize = $request->query->getInt("pageSize", 5);

        $items = $handler->handle($page, $pageSize);
        return $this->json($items);
    }
}