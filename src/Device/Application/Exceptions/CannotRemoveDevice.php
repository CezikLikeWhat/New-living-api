<?php

declare(strict_types=1);

namespace App\Device\Application\Exceptions;

use App\Core\Domain\Uuid;

class CannotRemoveDevice extends \Exception
{
    public static function byId(
        Uuid $deviceId,
        ?\Throwable $previousException = null
    ): self {
        return new self(
            message: sprintf(
                'Cannot remove device with id: %s from your account',
                $deviceId->toString()
            ),
            previous: $previousException
        );
    }
}
