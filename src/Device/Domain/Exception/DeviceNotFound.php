<?php

declare(strict_types=1);

namespace App\Device\Domain\Exception;

use App\Core\Domain\Uuid;

class DeviceNotFound extends \Exception
{
    public static function byId(Uuid $deviceId): self
    {
        return new self(
            sprintf('Device with id: %s not found', $deviceId->toString())
        );
    }
}