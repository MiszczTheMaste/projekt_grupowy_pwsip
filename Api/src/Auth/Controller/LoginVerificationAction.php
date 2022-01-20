<?php

namespace App\Auth\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class LoginVerificationAction extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke(): JsonResponse
    {
        $user = $this->security->getUser();
        return new JsonResponse(["username" => $user->getUserIdentifier(), "roles" => $user->getRoles()], Response::HTTP_OK);
    }
}
