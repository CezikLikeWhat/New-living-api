<?php

declare(strict_types=1);

namespace App\Device\Infrastructure\Doctrine\Repository;

use App\Core\Domain\Uuid;
use App\Device\Domain\DeviceFeature;
use App\Device\Domain\DeviceType;
use App\Device\Domain\MACAddress;
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

    public function removeAllByDeviceId(Uuid $deviceId): void
    {
        $arrayOfDeviceFeatures = $this->registry
            ->getRepository(DeviceFeature::class)
            ->findBy(['deviceId' => $deviceId]);

        foreach ($arrayOfDeviceFeatures as $deviceFeature) {
            $this->registry
                ->getManager()
                ->remove($deviceFeature);
        }
    }

    public function findByFeatureIdAndDeviceId(Uuid $featureId, Uuid $deviceId): ?DeviceFeature
    {
        return $this->registry
            ->getRepository(DeviceFeature::class)
            ->findOneBy([
                'featureId' => $featureId,
                'deviceId' => $deviceId,
            ]);
    }

    public function changeMacInPayloadByDeviceId(Uuid $deviceId, MACAddress $MACAddress): void
    {
        $arrayOfDeviceFeatures = $this->registry
            ->getRepository(DeviceFeature::class)
            ->findBy(['deviceId' => $deviceId]);

        foreach ($arrayOfDeviceFeatures as $deviceFeature) {
            /** @phpstan-ignore-next-line */
            $deviceFeature->payload['device']['mac'] = $MACAddress;
        }
    }

    public function changeTypeInPayloadByDeviceId(Uuid $deviceId, DeviceType $deviceType): void
    {
        $arrayOfDeviceFeatures = $this->registry
            ->getRepository(DeviceFeature::class)
            ->findBy(['deviceId' => $deviceId]);
        foreach ($arrayOfDeviceFeatures as $deviceFeature) {
            /** @phpstan-ignore-next-line */
            $deviceFeature->payload['device']['type'] = $deviceType->value;
        }
    }

    public function updatePayloadByDeviceId(Uuid $deviceId, array $payload): void
    {
        $arrayOfDeviceFeatures = $this->registry
            ->getRepository(DeviceFeature::class)
            ->findBy(['deviceId' => $deviceId]);
        foreach ($arrayOfDeviceFeatures as $deviceFeature) {
            $deviceFeature->payload = $payload;
        }
    }
}
