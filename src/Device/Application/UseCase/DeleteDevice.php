<?php

declare(strict_types=1);

namespace App\Device\Application\UseCase;

use App\Device\Application\Exceptions\CannotRemoveDevice;
use App\Device\Domain\Exception\DeviceNotFound;
use App\Device\Domain\Repository\DeviceFeatureRepository;
use App\Device\Domain\Repository\DeviceRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteDevice
{
    public function __construct(
        private readonly DeviceFeatureRepository $deviceFeatureRepository,
        private readonly DeviceRepository $deviceRepository,
    ) {
    }

    /**
     * @throws CannotRemoveDevice
     */
    public function __invoke(DeleteDevice\Command $command): void
    {
        try {
            $this->deviceRepository->remove($command->deviceId);
        } catch (DeviceNotFound $e) {
            throw CannotRemoveDevice::byId($command->deviceId, $e->getPrevious());
        }

        $this->deviceFeatureRepository->removeAllByDeviceId($command->deviceId);
    }
}
