<?php

declare(strict_types=1);

namespace App\Device\Application\UseCase\AddDeviceFeature;

use App\Core\Domain\Uuid;

class Command
{
    /**
     * @param array<mixed> $payload
     */
    public function __construct(
        public readonly Uuid $featureId,
        public readonly Uuid $deviceId,
        public readonly array $payload,
        public readonly ?Uuid $id = null
    ) {
    }
}
