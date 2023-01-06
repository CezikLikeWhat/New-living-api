<?php

declare(strict_types=1);

namespace App\Device\Domain;

use App\Core\Domain\Uuid;

class DeviceFeature
{
    /**
     * @param array<mixed> $payload
     */
    public function __construct(
        public readonly Uuid $id,
        public readonly Uuid $featureId,
        public readonly Uuid $deviceId,
        public array $payload,
    ) {
    }
}
