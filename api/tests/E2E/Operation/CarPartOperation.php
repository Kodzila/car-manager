<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E\Operation;

use Kodzila\Tests\E2E\Util\ApiClient;

final class CarPartOperation
{
    public function __construct(private ApiClient $apiClient)
    {
    }

    public function getByName(string $name): string
    {
        $all = $this->apiClient->get('/api/car_parts')->getHydraMembers();

        foreach ($all as $part) {
            if ($part['name'] === $name) {
                return $part['@id'];
            }
        }

        throw new \Exception(sprintf(
            'Car part with name %s does not exist',
            $name,
        ));
    }
}
