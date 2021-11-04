<?php

namespace App\Products\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Products\Handler\GetProductsHandler;

class GetProductsAction
{
    private GetProductsHandler $handler;

    public function __construct(GetProductsHandler $handler)
    {
        $this->handler = $handler;
    }
    
    public function __invoke():JsonResponse
    {
        $productCollection = $this->handler->handle();
        if(is_null($productCollection)){
            return new JsonResponse($productCollection, Response::HTTP_NOT_FOUND);
        } else{
            return new JsonResponse($productCollection, Response::HTTP_OK);
        }    
    }
}