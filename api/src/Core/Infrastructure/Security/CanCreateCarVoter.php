<?php

declare(strict_types=1);

namespace Kodzila\Core\Infrastructure\Security;

use Kodzila\Core\Domain\Entity\Car;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Webmozart\Assert\Assert;

final class CanCreateCarVoter extends Voter
{
    protected function supports($attribute, $subject): bool
    {
        $supportsAttribute = $attribute === 'CAR_CREATE';
        $supportsSubject = $subject instanceof Car;

        return $supportsAttribute && $supportsSubject;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        Assert::isInstanceOf($subject, Car::class);

        return $subject->getUser() === $token->getUser();
    }
}
