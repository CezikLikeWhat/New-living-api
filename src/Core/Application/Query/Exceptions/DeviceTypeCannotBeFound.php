<?php

declare(strict_types=1);

namespace App\Core\Application\Query\Exceptions;

class DeviceTypeCannotBeFound extends \Exception
{
    public static function byName(string $name): self
    {
        return new self(
            sprintf('Cannot found device with name: %s', $name)
        );
    }
}
