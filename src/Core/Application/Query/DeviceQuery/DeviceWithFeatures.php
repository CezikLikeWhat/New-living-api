<?php

declare(strict_types=1);

namespace App\Core\Application\Query\DeviceQuery;

use App\Core\Domain\Uuid;
use App\Device\Domain\DeviceType;
use App\Device\Domain\MACAddress;

class DeviceWithFeatures
{
    /**
     * @param array<mixed> $payload
     * @param DeviceFeature[] $features
     */
    public function __construct(
        public readonly Uuid $id,
        public readonly string $name,
        public readonly DeviceType $type,
        public readonly MACAddress $macAddress,
        public readonly \DateTimeImmutable $createdAt,
        public readonly array $payload,
        public readonly array $features,
    ) {
    }
}
