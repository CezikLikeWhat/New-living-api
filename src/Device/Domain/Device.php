<?php

declare(strict_types=1);

namespace App\Device\Domain;

use App\Core\Domain\Uuid;

class Device
{
    public function __construct(
        public readonly Uuid $id,
        public readonly string $name,
        public readonly DeviceType $deviceType,
        public readonly MACAddress $macAddress,
    ) {
    }
}
