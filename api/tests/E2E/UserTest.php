<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E;

use Kodzila\Tests\E2E\Util\Random;

final class UserTest extends BaseApiTest
{
    public function test_can_register(): void
    {
        $userActor = $this->userOperation->register(Random::email(), '1qaz2wsx');

        // Until login you cannot see your user
        $this->apiClient->get($userActor->getIri())->assertCode(401);

        $userActor->login();
        $this->apiClient->get($userActor->getIri())->contentData();
    }
}
