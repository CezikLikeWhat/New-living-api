<?php

declare(strict_types=1);

namespace App\Core\Domain\Clock;

use App\Core\Domain\Clock;
use DateTimeImmutable;

final class SystemClock implements Clock
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
