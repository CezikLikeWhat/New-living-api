<?php

declare(strict_types=1);

namespace App\Core\Application\Query\DeviceQuery;

use App\Core\Domain\Uuid;
use App\Device\Domain\DeviceType;
use App\Device\Domain\MACAddress;

class Device implements \JsonSerializable
{
    public function __construct(
        public readonly Uuid $id,
        public readonly string $name,
        public readonly DeviceType $deviceType,
        public readonly MACAddress $macAddress,
        public readonly \DateTimeImmutable $createdAt,
    ) {
    }

    /**
     * @return array{
     *     id: Uuid,
     *     name: string,
     *     device_type: string,
     *     mac_address: MACAddress,
     *     created_at: string
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'device_type' => $this->deviceType->name,
            'mac_address' => $this->macAddress,
            'created_at' => $this->createdAt->format('d-m-Y'),
        ];
    }
}
