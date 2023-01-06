<?php

declare(strict_types=1);

namespace App\Core\Application\Message;

use App\Core\Infrastructure\Symfony\Uuid4;
use App\Device\Domain\Repository\DeviceFeatureRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeviceStatus
{
    public function __construct(
        private readonly DeviceFeatureRepository $deviceFeatureRepository
    ) {
    }

    public function __invoke(DeviceStatus\Command $command): void
    {
        $this->deviceFeatureRepository->updatePayloadByDeviceId(
            Uuid4::fromString($command->message['device']['id']),
            $command->message
        );
    }
}
