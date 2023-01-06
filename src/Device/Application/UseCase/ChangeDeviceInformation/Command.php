<?php

declare(strict_types=1);

namespace App\Device\Application\UseCase\ChangeDeviceInformation;

use App\Core\Domain\Uuid;
use App\Device\Domain\DeviceType;
use App\Device\Domain\Exception\InvalidMACAddress;
use App\Device\Domain\MACAddress;

class Command
{
    public function __construct(
        public readonly Uuid $deviceId,
        public readonly string $deviceName,
        private readonly string $deviceType,
        private readonly string $macAddress
    ) {
    }

    public function deviceType(): DeviceType
    {
        return DeviceType::fromString($this->deviceType);
    }

    /**
     * @throws InvalidMACAddress
     */
    public function macAddress(): MACAddress
    {
        return new MACAddress($this->macAddress);
    }
}
