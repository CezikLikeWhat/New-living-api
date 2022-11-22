<?php

declare(strict_types=1);

namespace App\Device\Application\UseCase;

use App\Core\Domain\Clock;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\Device\Domain\Device;
use App\Device\Domain\DeviceType;
use App\Device\Domain\Exception\InvalidMACAddress;
use App\Device\Domain\MACAddress;
use App\Device\Domain\Repository\DeviceRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AddDevice
{
    public function __construct(
        private readonly DeviceRepository $repository,
        private readonly Clock $clock,
    ) {
    }

    /**
     * @throws InvalidMACAddress
     */
    public function __invoke(AddDevice\Command $command): void
    {
        $device = new Device(
            id: $command->id ?? Uuid4::generateNew(),
            userId: $command->userId,
            name: $command->name,
            deviceType: DeviceType::fromString($command->deviceType),
            macAddress: new MACAddress($command->macAddress),
            createdAt: $this->clock->now(),
        );

        $this->repository->add($device);
    }
}
