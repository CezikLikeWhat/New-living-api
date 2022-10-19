<?php

declare(strict_types=1);

namespace App\Device\Domain;

enum DeviceType: string
{
    case LIGHT_BULB = 'Light bulb';
    case LED_STRIP = 'Led strip';
    case DISTANCE_SENSOR = 'Distance sensor';

    public static function fromString(string $enumType): self
    {
        return self::from($enumType);
    }
}
