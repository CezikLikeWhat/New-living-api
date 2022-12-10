<?php

declare(strict_types=1);

namespace App\Device\Infrastructure\Doctrine\Repository;

use App\Core\Domain\Uuid;
use App\Device\Domain\Device;
use App\Device\Domain\Exception\DeviceNotFound;
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

    public function findById(Uuid $deviceId): ?Device
    {
        return $this->registry
            ->getRepository(Device::class)
            ->findOneBy(['id' => $deviceId]);
    }

    public function remove(Uuid $deviceId): void
    {
        $device = $this->findById($deviceId);

        if (!$device) {
            throw DeviceNotFound::byId($deviceId);
        }

        $this->registry
            ->getManager()
            ->remove($device);
    }
}
