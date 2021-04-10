<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E\Operation;

use Kodzila\Tests\E2E\Util\ApiClient;
use Kodzila\Tests\E2E\Util\UserActor;

final class UserOperation
{
    public function __construct(private ApiClient $apiClient)
    {
    }

    public function register(string $email, string $password): UserActor
    {
        $res = $this->apiClient->post('/api/users/register', [
            'email' => $email,
            'password' => $password,
        ])->contentData();

        return new UserActor($this->apiClient, $email, $password, $res['@id']);
    }
}
