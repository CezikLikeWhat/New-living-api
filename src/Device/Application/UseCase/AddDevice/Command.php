<?php

declare(strict_types=1);

namespace App\Device\Application\UseCase\AddDevice;

class Command
{
    public function __construct(
        public readonly string $name,
        public readonly string $deviceType,
        public readonly string $macAddress,
    ) {
    }
}
