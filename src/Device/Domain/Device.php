<?php

declare(strict_types=1);

namespace App\Device\Domain;

use App\Core\Domain\Uuid;

class Device
{
    public function __construct(
        public readonly Uuid $id,
        public readonly Uuid $userId,
        public string $name,
        public DeviceType $deviceType,
        public MACAddress $macAddress,
        public readonly \DateTimeImmutable $createdAt,
    ) {
    }
}
