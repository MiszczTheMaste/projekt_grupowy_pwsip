<?php

namespace App\Products\Controller;

use App\Products\CommandHandler\DeleteProductHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Products\CommandHandler\PostProductHandler;
use Symfony\Component\HttpFoundation\Request;

class DeleteProductAction
{
    private DeleteProductHandler $handler;

    public function __construct(DeleteProductHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(int $id): JsonResponse
    {
        try {
            $this->handler->handle($id);
        } catch (\Throwable $th) {
            return new JsonResponse(["message" => "Nie można usunąć produktu"], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse([], Response::HTTP_OK);
    }
}
