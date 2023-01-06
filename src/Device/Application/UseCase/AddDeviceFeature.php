<?php

declare(strict_types=1);

namespace App\Device\Application\UseCase;

use App\Core\Infrastructure\Symfony\Uuid4;
use App\Device\Domain\DeviceFeature;
use App\Device\Domain\Repository\DeviceFeatureRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AddDeviceFeature
{
    public function __construct(
        private readonly DeviceFeatureRepository $deviceFeatureRepository,
    ) {
    }

    public function __invoke(AddDeviceFeature\Command $command): void
    {
        $deviceFeature = new DeviceFeature(
            id: $command->id ?: Uuid4::generateNew(),
            featureId: $command->featureId,
            deviceId: $command->deviceId,
            payload: $command->payload,
        );
        $this->deviceFeatureRepository->add($deviceFeature);
    }
}
