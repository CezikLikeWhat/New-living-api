<?php

declare(strict_types=1);

namespace App\Device\Domain\Repository;

use App\Core\Domain\Uuid;
use App\Device\Domain\Device;
use App\Device\Domain\Exception\DeviceNotFound;

interface DeviceRepository
{
    public function add(Device $device): void;

    public function findById(Uuid $deviceID): ?Device;

    /**
     * @throws DeviceNotFound
     */
    public function remove(Uuid $deviceID): void;
}
