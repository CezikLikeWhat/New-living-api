<?php

declare(strict_types=1);

namespace App\Device\Infrastructure\Doctrine\Repository;

use App\Core\Domain\Uuid;
use App\Device\Domain\Device;
use App\Device\Domain\Repository\DeviceRepository;
use Doctrine\Persistence\ManagerRegistry;

class ORMDeviceRepository implements DeviceRepository
{
    public function __construct(
        private readonly ManagerRegistry $registry,
    ) {
    }

    public function add(Device $device): void
    {
        $this->registry->getManager()->persist($device);
    }

    public function findById(Uuid $deviceID): ?Device
    {
        return $this->registry
            ->getRepository(Device::class)
            ->findOneBy(['id' => $deviceID]);
    }
}
