<?php

namespace App\Orders\Controller;

use App\Orders\CommandHandler\PostOrderHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class PostOrderAction
{
    private PostOrderHandler $handler;
    private Security $security;

    public function __construct(PostOrderHandler $handler, Security $security)
    {
        $this->handler = $handler;
        $this->security = $security;
    }
    
    public function __invoke(Request $request):JsonResponse
    {
        try {
            $username = $this->security->getUser()->getUserIdentifier();
            $productsId = json_decode($request->get("products"));
            $this->handler->handle($username, $productsId);
        } catch (\Throwable $th) {
            return new JsonResponse(["message" => "Zapis zamówienia się nie powiódł"], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse([], Response::HTTP_CREATED);
    }
}