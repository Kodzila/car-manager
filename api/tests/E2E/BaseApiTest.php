<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Kodzila\Tests\E2E\Operation\TokenOperation;
use Kodzila\Tests\E2E\Operation\UserOperation;
use Kodzila\Tests\E2E\Util\ApiClient;
use Symfony\Component\Dotenv\Dotenv;

abstract class BaseApiTest extends ApiTestCase
{
    protected ApiClient $apiClient;
    protected UserOperation $userOperation;

    public function setUp(): void
    {
        parent::setUp();
        $this->apiClient = new ApiClient(static::createClient($this->loadDotEnvOptions()));
        $this->userOperation = new UserOperation($this->apiClient);
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
