<?php

declare(strict_types=1);

namespace App\Device\Application\UseCase;

use App\Core\Infrastructure\Symfony\Uuid4;
use App\Device\Application\UseCase\AddDevice\Command;
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
    ) {
    }

    /**
     * @throws InvalidMACAddress
     */
    public function __invoke(Command $command): void
    {
        $device = new Device(
            Uuid4::generateNew(),
            $command->name,
            DeviceType::fromString($command->deviceType),
            new MACAddress($command->macAddress)
        );

        $this->repository->add($device);
    }
}
