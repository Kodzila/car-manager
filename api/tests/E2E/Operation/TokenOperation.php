<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E\Operation;

use Kodzila\Tests\E2E\Util\ApiClient;
use Kodzila\Tests\E2E\Util\ApiResponse;

final class TokenOperation
{
    public function __construct(private ApiClient $apiClient)
    {
    }

    public function postToken(string $email, string $password): ApiResponse
    {
        return $this->apiClient->post('/api/auth/token', [
            'email' => $email,
            'password' => $password,
        ]);
    }
}
