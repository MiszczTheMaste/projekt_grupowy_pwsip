<?php

namespace App\Stock\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Stock\CommandHandler\SetStockHandler;

class SetStockAction
{
    private SetStockHandler $handler;

    const UNSIGNED_ERROR_CODE = 1690;

    public function __construct(SetStockHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(int $productId, int $amount): JsonResponse
    {
        try {
            $this->handler->handle($productId, $amount);
        } catch (\Throwable $th) {
            if ($th->getCode() === self::UNSIGNED_ERROR_CODE) {
                return new JsonResponse(["message" => "Nie ma wystarczajaco produktó na stanie"], Response::HTTP_BAD_REQUEST);
            } else {
                return new JsonResponse(["message" => "Nie udało się zmienić ilości"], Response::HTTP_NOT_FOUND);
            }
        }
        return new JsonResponse([], Response::HTTP_OK);
    }
}
