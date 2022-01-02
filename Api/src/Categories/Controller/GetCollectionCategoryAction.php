<?php

namespace App\Categories\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Categories\QueryHandler\GetCollectionCategoryHandler;
use Throwable;

class GetCollectionCategoryAction
{
    private GetCollectionCategoryHandler $handler;

    public function __construct(GetCollectionCategoryHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke($visible): JsonResponse
    {
        try {
            $categoryCollection = $this->handler->handle($visible);
        } catch (Throwable $e) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($categoryCollection, Response::HTTP_OK);
    }
}
