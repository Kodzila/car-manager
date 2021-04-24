<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E;

final class UserTest extends BaseApiTest
{
    public function test_can_register(): void
    {
        $userActor = $this->newUser();

        // Until login you cannot see your user
        $this->apiClient->get($userActor->getIri())->assertCode(401);

        $userActor->login();
        $this->apiClient->get($userActor->getIri())->contentData();
    }
}
