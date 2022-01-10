<?php

namespace App\Auth\Controller;

use App\Exception\CouldNotRegisterUser;
use App\Exception\PasswordCannotBeEmpty;
use App\Exception\UserAlreadyExists;
use App\Exception\UsernameCannotBeEmpty;
use App\User\Repository\UserRepository;
use App\Auth\CommandHandler\RegistrationHandler;
use App\Exception\RegisterWrongPassword;
use App\Exception\RegisterWrongUsername;
use Doctrine\ORM\EntityManagerInterface;
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

    private RegistrationHandler $handler;

    const DEFAULT_USER_ROLE = "ROLE_USER";

    public function __construct(RegistrationHandler $handler, UserRepository $userRepository, UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        $username = $requestData["username"];
        $password = $requestData["password"];

        try {
            $this->handler->handle($password, $username);
        } catch (PasswordCannotBeEmpty | UsernameCannotBeEmpty) {
            return new JsonResponse(["message" => "Invalid username or password"], Response::HTTP_BAD_REQUEST);
        } catch (RegisterWrongPassword) {
            return new JsonResponse(["message" => "Hasło musi mieć minimum 6 znaków"], Response::HTTP_BAD_REQUEST);
        } catch (RegisterWrongUsername) {
            return new JsonResponse(["message" => "Nazwa użytkownika musi mieć od 6 do 13 znaków"], Response::HTTP_BAD_REQUEST);
        } catch (CouldNotRegisterUser) {
            return new JsonResponse(["message" => "Could not register user"], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (UserAlreadyExists) {
            return new JsonResponse(["message" => "User already exists"], Response::HTTP_CONFLICT);
        }

        return new JsonResponse(["message" => "Ok"], Response::HTTP_CREATED);
    }
}
