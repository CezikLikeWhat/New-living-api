<?php

declare(strict_types=1);

namespace App\Core\Application\Query;

use App\Core\Application\Query\DeviceQuery\Device;
use App\Core\Application\Query\DeviceQuery\DeviceWithFeatures;
use App\Core\Application\Query\DeviceQuery\MostPopularDeviceType;
use App\Core\Domain\Uuid;

interface DeviceQuery
{
    /**
     * @return Device[]
     */
    public function getAllDevicesByUserId(Uuid $id): array;

    public function getMostPopularDeviceTypeByUserId(Uuid $id): MostPopularDeviceType;

    public function getMostPopularDeviceType(): MostPopularDeviceType;

    public function getDeviceInformationById(Uuid $deviceId): DeviceWithFeatures;
}
