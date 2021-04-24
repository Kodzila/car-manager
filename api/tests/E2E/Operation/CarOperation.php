<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E\Operation;

use Kodzila\Tests\E2E\Util\ApiClient;
use Kodzila\Tests\E2E\Util\ApiResponse;
use Kodzila\Tests\E2E\Util\UserActor;

final class CarOperation
{
    public function __construct(private ApiClient $apiClient)
    {
    }

    public function post(UserActor $user, string $name): ApiResponse
    {
        return $this->apiClient->post(
            '/api/cars',
            [
                'user' => $user->getIri(),
                'name' => $name,
            ],
        );
    }

    public function newCar(UserActor $user): string
    {
        return $this->post($user, 'Test car')->contentData()['@id'];
    }

    public function getSelf(): ApiResponse
    {
        return $this->apiClient->get('/api/self/cars');
    }
}
