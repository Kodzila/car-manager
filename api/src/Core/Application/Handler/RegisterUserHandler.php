<?php

declare(strict_types=1);

namespace Kodzila\Core\Application\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Kodzila\Core\Application\Command\RegisterUserCommand;
use Kodzila\Core\Domain\Entity\User;
use Kodzila\Core\Domain\Policy\UserUniquenessPolicy;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class RegisterUserHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordEncoderInterface $userPasswordEncoder,
        private UserUniquenessPolicy $userUniquenessPolicy,
    ) {
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        $user = User::create(
            $this->userPasswordEncoder,
            $this->userUniquenessPolicy,
            $command->email,
            $command->password,
        );

        $this->entityManager->persist($user);
    }
}
