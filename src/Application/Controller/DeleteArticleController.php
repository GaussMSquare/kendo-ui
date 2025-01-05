<?php

namespace App\Application\Controller;

use App\Application\Command\DeleteArticleHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteArticleController extends AbstractController
{
    #[Route('/api/article/{id}', name: 'delete_article_api', methods: ['DELETE'])]
    public function api(int $id, DeleteArticleHandler $handler): JsonResponse
    {
        $handler->handle($id);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}