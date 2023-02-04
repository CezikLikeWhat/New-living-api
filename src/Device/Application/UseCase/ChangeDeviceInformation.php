<?php

declare(strict_types=1);

namespace App\Device\Application\UseCase;

use App\Device\Domain\Exception\DeviceNotFound;
use App\Device\Domain\Exception\InvalidMACAddress;
use App\Device\Domain\Repository\DeviceFeatureRepository;
use App\Device\Domain\Repository\DeviceRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ChangeDeviceInformation
{
    public function __construct(
        private readonly DeviceRepository $deviceRepository,
        private readonly DeviceFeatureRepository $deviceFeatureRepository,
    ) {
    }

    /**
     * @throws DeviceNotFound
     * @throws InvalidMACAddress
     */
    public function __invoke(ChangeDeviceInformation\Command $command): void
    {
        $oldDevice = $this->deviceRepository->findById($command->deviceId);

        if (!$oldDevice) {
            throw DeviceNotFound::byId($command->deviceId);
        }

        if ($oldDevice->name !== $command->deviceName) {
            $oldDevice->name = $command->deviceName;
        }

        if ($oldDevice->deviceType !== $command->deviceType()) {
            $oldDevice->deviceType = $command->deviceType();
            $this->deviceFeatureRepository->changeTypeInPayloadByDeviceId($command->deviceId, $command->deviceType());
        }

        if ($oldDevice->macAddress !== $command->macAddress()) {
            $oldDevice->macAddress = $command->macAddress();
            $this->deviceFeatureRepository->changeMacInPayloadByDeviceId($command->deviceId, $command->macAddress());
        }
    }
}
