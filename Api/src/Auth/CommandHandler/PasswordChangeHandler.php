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
use Symfony\Component\Security\Core\Security;

class PasswordChangeHandler extends AbstractController
{
    private UserRepository $userRepository;

    private UserPasswordHasherInterface $passwordEncoder;

    private EntityManagerInterface $entityManager;

    private Security $security;

    CONST DEFAULT_USER_ROLE = "ROLE_USER";

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $entityManager, Security $security)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function handle(string $password): void
    {
        $user = $this->security->getUser();
        $username = $user->getUserIdentifier();

        $username = new Username($username);
        $password = new Password($password);

        try {
            $user = $this->userRepository->findOneBy([
                "username" => $username->getValue()
            ]);
        } catch (Exception $e) {
            throw new CouldNotRegisterUser();
        }

        $user->setUsername($username);
        $user->setPassword($this->passwordEncoder->hashPassword($user, $password));
        
        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (Exception $e) {
            throw new CouldNotRegisterUser();
        }
    }
}
