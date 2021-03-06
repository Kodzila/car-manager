<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E;

final class ActionTest extends BaseApiTest
{
    public function test_can_add_action(): void
    {
        $user = $this->userOperation->newUser();
        $user->login();
        $carIri = $this->carOperation->post($user, 'Opel Astra')->contentData()['@id'];
        $engineOilIri = $this->carPartOperation->getByName('Engine oil');

        $this->actionOperation->post(
            $carIri,
            $engineOilIri,
            '24-04-2021',
            487,
            null,
            'AutoGasSaxonia',
            90856,
        )->assertSuccess();
    }

    public function test_can_fetch_only_own_actions(): void
    {
        $user1 = $this->userOperation->newUser();
        $user1->login();
        $carIri = $this->carOperation->post($user1, 'Opel Astra')->contentData()['@id'];
        $engineOilIri = $this->carPartOperation->getByName('Engine oil');

        $this->actionOperation->post(
            $carIri,
            $engineOilIri,
            '24-04-2021',
            487,
            null,
            'AutoGasSaxonia',
            90856,
        )->assertSuccess();

        $user2 = $this->userOperation->newUser();
        $user2->login();
        $carIri = $this->carOperation->post($user2, 'Opel Astra')->contentData()['@id'];
        $engineOilIri = $this->carPartOperation->getByName('Engine oil');

        $this->actionOperation->post(
            $carIri,
            $engineOilIri,
            '24-04-2021',
            487,
            null,
            'AutoGasSaxonia',
            90856,
        )->assertSuccess();

        $actions = $this->actionOperation->getSelf()->getHydraMembers();
        self::assertCount(1, $actions);
    }

    public function test_can_filter_by_car(): void
    {
        $user = $this->userOperation->newUser();
        $user->login();

        $engineOilIri = $this->carPartOperation->getByName('Engine oil');

        $car1 = $this->carOperation->newCar($user);
        $car2 = $this->carOperation->newCar($user);

        $this->actionOperation->newAction($car1, $engineOilIri);
        $this->actionOperation->newAction($car2, $engineOilIri);

        self::assertCount(
            2,
            $this->actionOperation->getSelf()->getHydraMembers(),
        );

        self::assertCount(
            1,
            $this->actionOperation->getSelf(carIri: $car1)->getHydraMembers(),
        );
    }
}
