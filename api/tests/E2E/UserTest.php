<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E;

use Kodzila\Tests\E2E\Util\Random;

final class UserTest extends BaseApiTest
{
    public function test_can_register(): void
    {
        $email = Random::email();
        $password = '1qaz2wsx';

        $this->userOperation->register($email, $password)->assertSuccess();
        $this->tokenOperation->postToken($email, $password)->assertSuccess(true);
    }
}
