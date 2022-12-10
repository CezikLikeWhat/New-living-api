<?php

declare(strict_types=1);

namespace App\Device\Infrastructure\Doctrine\Repository;

use App\Core\Domain\Uuid;
use App\Device\Domain\DeviceFeature;
use App\Device\Domain\Repository\DeviceFeatureRepository;
use Doctrine\Persistence\ManagerRegistry;

class ORMDeviceFeatureRepository implements DeviceFeatureRepository
{
    public function __construct(
        private readonly ManagerRegistry $registry,
    ) {
    }

    public function add(DeviceFeature $deviceFeature): void
    {
        $this->registry->getManager()->persist($deviceFeature);
    }

    public function findByFeatureIdAndDeviceId(Uuid $featureId, Uuid $deviceId): ?DeviceFeature
    {
        return $this->registry
            ->getRepository(DeviceFeature::class)
            ->findOneBy([
                'featureId' => $featureId,
                'deviceId' => $deviceId
            ]);
    }
}