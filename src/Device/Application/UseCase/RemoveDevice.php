<?php

declare(strict_types=1);

namespace App\Device\Application\UseCase;

use App\Device\Application\Exceptions\CannotRemoveDevice;
use App\Device\Domain\Exception\DeviceNotFound;
use App\Device\Domain\Repository\DeviceRepository;

class RemoveDevice
{
    public function __construct(
        public readonly DeviceRepository $deviceRepository,
    ) {
    }

    /**
     * @throws CannotRemoveDevice
     */
    public function __invoke(RemoveDevice\Command $command): void
    {
        try {
            $this->deviceRepository->remove($command->deviceId);
        } catch (DeviceNotFound $e) {
            throw CannotRemoveDevice::byId($command->deviceId, $e->getPrevious());
        }
    }
}
