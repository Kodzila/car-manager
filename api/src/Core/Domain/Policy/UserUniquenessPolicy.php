<?php

declare(strict_types=1);

namespace Kodzila\Core\Domain\Policy;

use Doctrine\ORM\EntityManagerInterface;
use Kodzila\Core\Domain\Entity\User;
use Webmozart\Assert\Assert;

final class UserUniquenessPolicy
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function check(string $email): void
    {
        $userWithEmail = $this->entityManager->getRepository(User::class)->findBy([
            'email' => $email,
        ]);

        Assert::isEmpty($userWithEmail, sprintf(
            'User with email %s already exist',
            $email,
        ));
    }
}
