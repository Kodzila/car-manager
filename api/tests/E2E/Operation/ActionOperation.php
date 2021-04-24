<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E\Operation;

use Kodzila\Tests\E2E\Util\ApiClient;
use Kodzila\Tests\E2E\Util\ApiResponse;

final class ActionOperation
{
    public function __construct(private ApiClient $apiClient)
    {
    }

    public function post(
        string $carIri,
        string $carPartIri,
        string $actionedAt,
        float $cost,
        ?string $description,
        ?string $vendor,
        ?int $distance,
    ): ApiResponse {
        return $this->apiClient->post(
            '/api/actions',
            [
                'car' => $carIri,
                'carPart' => $carPartIri,
                'actionedAt' => $actionedAt,
                'cost' => $cost,
                'description' => $description,
                'vendor' => $vendor,
                'distance' => $distance,
            ],
        );
    }

    public function newAction(string $carIri, string $carPartIri): string
    {
        return $this->post(
            $carIri,
            $carPartIri,
            '24-04-2021',
            111,
            'test descr',
            'test vendor',
            11111,
        )->contentData()['@id'];
    }

    public function getSelf(?string $carIri = null): ApiResponse
    {
        $url = '/api/self/actions' . '?';
        $carIri && $url .= 'car=' . urlencode($carIri);

        return $this->apiClient->get($url);
    }
}
