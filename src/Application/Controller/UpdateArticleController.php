<?php

namespace App\Application\Controller;

use App\Application\Command\UpdateArticleHandler;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UpdateArticleController extends AbstractController
{
    #[Route('/api/article/{id}', name: 'update_article_api', methods: ['PUT'])]
    public function api(int $id, Request $request, UpdateArticleHandler $handler, LoggerInterface $logger): JsonResponse
    {
        $params = json_decode($request->getContent(), true);
        $data = $handler->handle($id, $params);

        return new JsonResponse($data);
    }
}