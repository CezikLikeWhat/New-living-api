<?php

declare(strict_types=1);

namespace App\Device\Domain\Exception;

use App\Core\Domain\Uuid;

class DeviceFeatureNotFound extends \Exception
{
    public static function byFeatureAndDeviceId(Uuid $featureId, Uuid $deviceId): self
    {
        return new self(
            sprintf('Device Feature for feature id (%s) and device id (%s) not found', $featureId->toString(), $deviceId->toString())
        );
    }
}
