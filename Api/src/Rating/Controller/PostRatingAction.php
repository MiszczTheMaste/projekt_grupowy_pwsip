<?php

namespace App\Rating\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Rating\CommandHandler\PostRatingHandler;
use Symfony\Component\Security\Core\Security;

class PostRatingAction
{
    private PostRatingHandler $handler;
    private Security $security;

    CONST DUPLICATE_ERROR_KEY = 1062;

    public function __construct(PostRatingHandler $handler, Security $security)
    {
        $this->handler = $handler;
        $this->security = $security;
    }
    
    public function __invoke(int $id, int $rating):JsonResponse
    {
        try {
            $username = $this->security->getUser()->getUserIdentifier();
            $this->handler->handle($id, $rating, $username);
        } catch (\Throwable $th) {
            if($th->getCode() === SELF::DUPLICATE_ERROR_KEY){
                return new JsonResponse(["message" => "Produkt już oceniony"], Response::HTTP_CONFLICT);
            } else{
                return new JsonResponse(["message" => "Nie można ocenić produktu"], Response::HTTP_BAD_REQUEST);
            }
        }
        return new JsonResponse([], Response::HTTP_CREATED);
    }
}