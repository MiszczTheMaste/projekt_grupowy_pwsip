<?php

namespace App\Products\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Products\Handler\PutProductHandler;
use Symfony\Component\HttpFoundation\Request;

class PutProductAction
{
    private PutProductHandler $handler;

    public function __construct(PutProductHandler $handler)
    {
        $this->handler = $handler;
    }
    
    public function __invoke(Request $request):JsonResponse
    {
        if($this->handler->handle($request)){
            return new JsonResponse('{"Product put"}', Response::HTTP_CREATED);
        } else{
            return new JsonResponse('{"Could not put product"}', Response::HTTP_BAD_REQUEST);
        }    
    }
}