<?php

namespace App\Auth\Controller;

use App\Entity\User;
use App\User\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationAction extends AbstractController
{
    private UserRepository $userRepository;

    private UserPasswordHasherInterface $passwordEncoder;

    private EntityManagerInterface $entityManager;

    CONST DEFAULT_USER_ROLE = "ROLE_USER";

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(),true);
        $username = $requestData["username"];
        $password = $requestData["password"];

        if (empty($username) || empty($password)) {
            return new JsonResponse(["message" => "Invalid username or password"], Response::HTTP_BAD_REQUEST);
        }

        try {
            $user = $this->userRepository->findOneBy([
                "username" => $username
            ]);
        } catch (Exception $e) {
            return new JsonResponse(["message" => "Something went wrong"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (!is_null($user)) {
            return new JsonResponse(["message" => "User already exists"], Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($this->passwordEncoder->hashPassword($user, $password));
        $user->setRoles([SELF::DEFAULT_USER_ROLE]);
        
        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (Exception $e) {
            return new JsonResponse(["message" => "Could not register user"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(["message" => "Ok"], Response::HTTP_CREATED);
    }
}
