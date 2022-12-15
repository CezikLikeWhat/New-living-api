<?php

declare(strict_types=1);

namespace App\Core\Application\Query\DeviceQuery;

use App\Device\Domain\DeviceType;
use App\Device\Domain\MACAddress;

class DeviceWithFeatures
{
    /**
     * @param array{
     *     feature_name: string,
     *     display_type: string,
     *     payload: array<mixed>
     * }[] $features
     */
    public function __construct(
        public readonly string $deviceName,
        public readonly DeviceType $deviceType,
        public readonly MACAddress $macAddress,
        public readonly \DateTimeImmutable $createdAt,
        public readonly array $features,
    ) {
    }
}
