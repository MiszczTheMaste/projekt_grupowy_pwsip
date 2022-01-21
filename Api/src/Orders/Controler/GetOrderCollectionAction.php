<?php

namespace App\Orders\Controller;

use App\Orders\QueryHandler\GetOrderCollectionHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class GetOrderCollectionAction
{
    private GetOrderCollectionHandler $handler;
    private Security $security;

    public function __construct(GetOrderCollectionHandler $handler, Security $security)
    {
        $this->handler = $handler;
        $this->security = $security;
    }

    public function __invoke(): JsonResponse
    {
        try {
            $username = $this->security->getUser()->getUserIdentifier();
            $orderCollection = $this->handler->handle($username);
        } catch (\Throwable $th) {
            return new JsonResponse(["message" => "Nie znaleziono zamówień"], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse(["orders" => $orderCollection], Response::HTTP_CREATED);
    }
}
