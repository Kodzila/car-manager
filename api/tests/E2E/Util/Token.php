<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E\Util;

/**
 * @psalm-immutable
 */
final class Token
{
    public function __construct(
        public string $token,
    ) {
    }
}
