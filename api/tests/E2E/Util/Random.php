<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E\Util;

final class Random
{
    public static function email(): string
    {
        return sprintf(
            '%s@kodzila.com',
            self::string(),
        );
    }

    public static function string(): string
    {
        return md5(microtime());
    }
}
