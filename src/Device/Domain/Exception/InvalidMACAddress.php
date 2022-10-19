<?php

declare(strict_types=1);

namespace App\Device\Domain\Exception;

class InvalidMACAddress extends \Exception
{
    public static function byFormat(string $mac): self
    {
        return new self(
            sprintf(
                'Invalid MAC address format: %s\nThe correct formats are: XX:XX:XX:XX:XX:XX, XX-XX-XX-XX-XX, XXXXXXXXXXXX',
                $mac
            )
        );
    }
}
