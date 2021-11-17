<?php

namespace App\Products\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Products\QueryHandler\GetProductHandler;

class GetProductAction
{
    private GetProductHandler $handler;

    public function __construct(GetProductHandler $handler)
    {
        $this->handler = $handler;
    }
    
    public function __invoke($id):JsonResponse
    {
        $product = $this->handler->handle($id);
        if(is_null($product)){
            return new JsonResponse($product, Response::HTTP_NOT_FOUND);
        } else{
            return new JsonResponse($product, Response::HTTP_OK);
        }    
    }
}