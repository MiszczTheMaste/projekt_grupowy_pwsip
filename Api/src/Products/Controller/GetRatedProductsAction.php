<?php

namespace App\Products\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Products\QueryHandler\GetRatedProductsHandler;

class GetRatedProductsAction
{
    private GetRatedProductsHandler $handler;

    public function __construct(GetRatedProductsHandler $handler)
    {
        $this->handler = $handler;
    }
    
    public function __invoke():JsonResponse
    {
        try {
            $productsId = $this->handler->handle();
        } catch (\Throwable $th) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse(["products" => $productsId], Response::HTTP_OK);  
    }
}