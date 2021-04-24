<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Kodzila\Tests\E2E\Operation\CarOperation;
use Kodzila\Tests\E2E\Operation\UserOperation;
use Kodzila\Tests\E2E\Util\ApiClient;
use Kodzila\Tests\E2E\Util\Random;
use Kodzila\Tests\E2E\Util\UserActor;
use Symfony\Component\Dotenv\Dotenv;

abstract class BaseApiTest extends ApiTestCase
{
    protected ApiClient $apiClient;
    protected UserOperation $userOperation;
    protected CarOperation $carOperation;

    public function setUp(): void
    {
        parent::setUp();
        $this->apiClient = new ApiClient(static::createClient($this->loadDotEnvOptions()));
        $this->userOperation = new UserOperation($this->apiClient);
        $this->carOperation = new CarOperation($this->apiClient);
    }

    protected function newUser(): UserActor
    {
        return $this->userOperation->register(Random::email(), '1qaz2wsx');
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
     */
    private function loadDotEnvOptions(): array
    {
        $options = [];
        $dotEnv = new Dotenv();
        $dotEnv->load(__DIR__ . '/../../.env.local');
        $dotEnv->populate($options);

        return $options;
    }
}
