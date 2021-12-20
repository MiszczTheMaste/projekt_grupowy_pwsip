<?php

namespace App\Products\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Products\CommandHandler\PostProductHandler;
use Symfony\Component\HttpFoundation\Request;

class PostProductAction
{
    private PostProductHandler $handler;

    public function __construct(PostProductHandler $handler)
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