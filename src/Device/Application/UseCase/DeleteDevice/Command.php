<?php

declare(strict_types=1);

namespace App\Device\Application\UseCase\DeleteDevice;

use App\Core\Domain\Uuid;

class Command
{
    public function __construct(
        public readonly Uuid $deviceId,
    ) {
    }
}
