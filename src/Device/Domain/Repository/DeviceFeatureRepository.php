<?php

declare(strict_types=1);

namespace App\Device\Domain\Repository;

use App\Core\Domain\Uuid;
use App\Device\Domain\DeviceFeature;
use App\Device\Domain\DeviceType;
use App\Device\Domain\MACAddress;

interface DeviceFeatureRepository
{
    public function add(DeviceFeature $deviceFeature): void;

    public function removeAllByDeviceId(Uuid $deviceId): void;

    public function findByFeatureIdAndDeviceId(Uuid $featureId, Uuid $deviceId): ?DeviceFeature;

    public function changeMacInPayloadByDeviceId(Uuid $deviceId, MACAddress $MACAddress): void;

    public function changeTypeInPayloadByDeviceId(Uuid $deviceId, DeviceType $deviceType): void;

    /**
     * @param array<mixed> $payload
     */
    public function updatePayloadByDeviceId(Uuid $deviceId, array $payload): void;
}
