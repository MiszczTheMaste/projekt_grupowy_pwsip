<?php

namespace App\Auth\CommandHandler;

use App\Entity\User;
use App\Exception\CouldNotRegisterUser;
use App\Exception\UserAlreadyExists;
use App\User\Repository\UserRepository;
use App\ValueObject\Password;
use App\ValueObject\Username;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationHandler extends AbstractController
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

    public function handle(string $password, string $username): void
    {
        $username = new Username($username);
        $password = new Password($password);

        try {
            $user = $this->userRepository->findOneBy([
                "username" => $username->getValue()
            ]);
        } catch (Exception $e) {
            throw new CouldNotRegisterUser();
        }

        if (!is_null($user)) {
            throw new UserAlreadyExists();
        }

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($this->passwordEncoder->hashPassword($user, $password));
        $user->setRoles([SELF::DEFAULT_USER_ROLE]);
        
        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (Exception $e) {
            throw new CouldNotRegisterUser();
        }
    }
}
