<?php

declare(strict_types=1);

namespace App\Device\Application\UseCase\AddDevice;

use App\Core\Domain\Uuid;

class Command
{
    public function __construct(
        public readonly Uuid $userId,
        public readonly string $name,
        public readonly string $deviceType,
        public readonly string $macAddress,
        public readonly ?Uuid $id = null,
    ) {
    }
}
