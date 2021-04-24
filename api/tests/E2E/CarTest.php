<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E;

final class CarTest extends BaseApiTest
{
    public function test_can_manage_cars(): void
    {
        $user = $this->newUser();
        $user->login();

        $carData = $this->carOperation->post($user, 'Opel Astra')->contentData();

        $cars = $this->carOperation->getSelf()->getHydraMembers();
        self::assertCount(1, $cars);
    }

    public function test_cannot_create_car_for_other_user(): void
    {
        $user1 = $this->newUser();
        $user2 = $this->newUser();

        $user1->login();
        $this->carOperation->post($user2, 'Opel Astra')->assertCode(403);
    }
}
