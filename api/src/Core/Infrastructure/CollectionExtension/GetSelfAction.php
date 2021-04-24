<?php

declare(strict_types=1);

namespace Kodzila\Core\Infrastructure\CollectionExtension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use Kodzila\Core\Domain\Entity\Action;
use Kodzila\Core\Domain\Entity\Car;
use Kodzila\Core\Domain\Entity\User;
use Symfony\Component\Security\Core\Security;
use Webmozart\Assert\Assert;

final class GetSelfAction implements QueryCollectionExtensionInterface
{
    public function __construct(private Security $security)
    {
    }

    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        ?string $operationName = null
    ): void {
        if ($resourceClass !== Action::class) {
            return;
        }

        if ($operationName !== 'GET_SELF') {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        Assert::string($rootAlias);
        $user = $this->security->getUser();
        Assert::isInstanceOf($user, User::class);

        $queryBuilder
            ->leftJoin($rootAlias . '.car', 'c')
            ->andWhere('c.user = :current_user')
            ->setParameter('current_user', $user->getId())
        ;
    }
}
