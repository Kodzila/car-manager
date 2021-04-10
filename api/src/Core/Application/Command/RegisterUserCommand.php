<?php

declare(strict_types=1);

namespace Kodzila\Core\Application\Command;

use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @psalm-immutable
 */
#[ApiResource(
    collectionOperations: [
        'POST' => [
            'messenger' => true,
            'status' => 202,
            'path' => '/users/register',
            'openapi_context' => [
                'tags' => ['User'],
            ],
            'normalization_context' => [
                'groups' => ['user:read'],
            ],
        ],
    ],
    itemOperations: [],
)]
final class RegisterUserCommand
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }
}
