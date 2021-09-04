<?php

declare(strict_types=1);

namespace Kodzila\Tests\Architecture;

use Kodzila\ArchValidator\Architecture;
use Kodzila\ArchValidator\Rule\Extension\CoreModuleRule;
use Kodzila\ArchValidator\Rule\Extension\DomainDrivenDesignRule;
use Kodzila\ArchValidator\Rule\Extension\DomainForbiddenDependenciesRule;
use PHPUnit\Framework\TestCase;

final class ArchitectureTest extends TestCase
{
    public function test(): void
    {
        $architecture = Architecture::build()
            ->defineModule(
                'Core',
                'Kodzila\\Core',
                'src/Core',
            )
        ;

        $coreModuleName = 'Core';
        $dddModules = ['Core'];

        // List of stable dependencies, on which domain can safely depend
        $allowedDomainDependencies = [
            'ApiPlatform\Core\Annotation\\',
            'ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\\',

            'Doctrine\ORM\Mapping',
            'Doctrine\ORM\EntityManagerInterface',

            'Ramsey\Uuid\\',

            'DateTimeImmutable',

            'Webmozart\Assert\Assert',

            'Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface',
            'Symfony\Component\Security\Core\User\UserInterface',
            'Symfony\Component\Serializer\Annotation\Groups',
        ];

        $architecture->checkRules([
            new CoreModuleRule($coreModuleName),
            new DomainDrivenDesignRule($dddModules),
            new DomainForbiddenDependenciesRule($dddModules, $allowedDomainDependencies),
        ]);

        self::assertTrue(true);
    }
}
