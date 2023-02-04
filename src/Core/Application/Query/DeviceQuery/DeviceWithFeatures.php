<?php

declare(strict_types=1);

namespace App\Core\Application\Query\DeviceQuery;

use App\Core\Domain\Uuid;
use App\Device\Domain\DeviceType;
use App\Device\Domain\MACAddress;

class DeviceWithFeatures implements \JsonSerializable
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

    /**
     * @return array{
     *     id: string,
     *     name: string,
     *     type: string,
     *     macAddress: string,
     *     createdAt: string,
     *     payload: array<mixed>,
     *     features: DeviceFeature[],
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'type' => $this->type->value,
            'macAddress' => (string) $this->macAddress,
            'createdAt' => $this->createdAt->format('d-m-Y'),
            'payload' => $this->payload,
            'features' => $this->features,
        ];
    }
}
