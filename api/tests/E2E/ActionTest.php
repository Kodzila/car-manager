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
}
