<?php

namespace App\Application\Controller;

use App\Application\Command\CreateArticleHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateArticleController extends AbstractController
{
    #[Route('/api/article', name: 'create_article_api', methods: ['POST'])]
    public function api(Request $request, CreateArticleHandler $handler): JsonResponse
    {
        $params = json_decode($request->getContent(), true);
        $data = $handler->handle($params);
        return new JsonResponse($data, Response::HTTP_CREATED);
    }
}