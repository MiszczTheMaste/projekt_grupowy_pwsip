<?php

namespace App\Categories\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Categories\QueryHandler\GetCategoryHandler;
use Throwable;

class GetCategoryAction
{
    private GetCategoryHandler $handler;

    public function __construct(GetCategoryHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke($id): JsonResponse
    {
        try {
            $category = $this->handler->handle($id);
        } catch (Throwable $e) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($category, Response::HTTP_OK);
    }
}
