<?php

declare(strict_types=1);

namespace App\Core\Application\Message;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeviceStatus
{
    public function __construct(
    ) {
    }

    public function __invoke(DeviceStatus\Command $command): void
    {
    }
}
