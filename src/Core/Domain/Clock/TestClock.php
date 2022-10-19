<?php

declare(strict_types=1);

namespace App\Core\Domain\Clock;

use App\Core\Domain\Clock;
use DateTimeImmutable;

final class TestClock implements Clock
{
    private static ?\DateTimeImmutable $currentDate = null;

    public function setCurrentDateTime(?DateTimeImmutable $time): void
    {
        self::$currentDate = $time;
    }

    public function now(): DateTimeImmutable
    {
        return self::$currentDate ?? new \DateTimeImmutable();
    }
}
