<?php

namespace App\Categories\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Categories\QueryHandler\PostCategoryHandler;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class PostCategoryAction
{
    private PostCategoryHandler $handler;

    public function __construct(PostCategoryHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(),true);
            $category = $this->handler->handle($data);
        } catch (Throwable $e) {
            return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse($category, Response::HTTP_CREATED);
    }
}
