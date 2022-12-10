<?php

declare(strict_types=1);

namespace App\Device\Domain\Repository;

use App\Core\Domain\Uuid;
use App\Device\Domain\DeviceFeature;

interface DeviceFeatureRepository
{
    public function add(DeviceFeature $deviceFeature): void;

    public function findByFeatureIdAndDeviceId(Uuid $featureId, Uuid $deviceId): ?DeviceFeature;
}
