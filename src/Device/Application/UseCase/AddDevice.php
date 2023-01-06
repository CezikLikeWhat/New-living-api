<?php

declare(strict_types=1);

namespace App\Device\Application\UseCase;

use App\Core\Domain\Clock;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\Device\Application\UseCase\AddDeviceFeature\Command as addDeviceFeatureCommand;
use App\Device\Domain\Device;
use App\Device\Domain\DeviceType;
use App\Device\Domain\Exception\FeatureNotFound;
use App\Device\Domain\Exception\InvalidMACAddress;
use App\Device\Domain\MACAddress;
use App\Device\Domain\Repository\DeviceRepository;
use App\Device\Domain\Repository\FeatureRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class AddDevice
{
    public function __construct(
        private readonly FeatureRepository $featureRepository,
        private readonly MessageBusInterface $messageBus,
        private readonly DeviceRepository $repository,
        private readonly Clock $clock,
    ) {
    }

    /**
     * @throws InvalidMACAddress
     * @throws FeatureNotFound
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

        $deviceFeaturesPayload = DeviceType::getPayloadByDevice($device);

        $turnOnFeature = $this->featureRepository->findByCodeName('TURN_ON');
        $turnOffFeature = $this->featureRepository->findByCodeName('TURN_OFF');

        if (!$turnOnFeature) {
            throw FeatureNotFound::byCodeName('TURN_ON');
        }
        if (!$turnOffFeature) {
            throw FeatureNotFound::byCodeName('TURN_OFF');
        }

        $this->messageBus->dispatch(new addDeviceFeatureCommand(
            $turnOnFeature->id,
            $device->id,
            $deviceFeaturesPayload,
        ));
        $this->messageBus->dispatch(new addDeviceFeatureCommand(
            $turnOffFeature->id,
            $device->id,
            $deviceFeaturesPayload,
        ));

        /** @var array<string,mixed> $features
         *  @phpstan-ignore-next-line
         */
        $features = $deviceFeaturesPayload['actual_status']['features'];
        foreach (array_keys($features) as $featureName) {
            $feature = $this->featureRepository->findByCodeName($featureName);

            if (!$feature) {
                throw FeatureNotFound::byCodeName($featureName);
            }
            $this->messageBus->dispatch(new addDeviceFeatureCommand(
                $feature->id,
                $device->id,
                $deviceFeaturesPayload,
            ));
        }
    }
}
