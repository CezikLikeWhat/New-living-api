<?php

declare(strict_types=1);

namespace App\Device\Domain;

enum DeviceType: string
{
    case LIGHT_BULB = 'Light bulb';
    case LED_RING = 'Led ring';
    case DISTANCE_SENSOR = 'Distance sensor';

    public static function fromString(string $enumType): self
    {
        return self::from($enumType);
    }

    /**
     * @return self[]
     */
    public static function getAllTypes(): array
    {
        return array_map(static fn (self $type) => $type, self::cases());
    }

    /**
     * @return array<mixed>
     */
    public static function getPayloadByDevice(Device $device): array
    {
        return match ($device->deviceType) {
            self::LIGHT_BULB => [
                'device' => [
                    'mac' => (string) $device->macAddress,
                    'type' => $device->deviceType->value,
                    'id' => $device->id->toString(),
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'CHANGE_COLOR_LIGHT_BULB' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            self::LED_RING => [
                'device' => [
                    'mac' => (string) $device->macAddress,
                    'type' => $device->deviceType->value,
                    'id' => $device->id->toString(),
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            self::DISTANCE_SENSOR => [
                'device' => [
                    'mac' => (string) $device->macAddress,
                    'type' => $device->deviceType->value,
                    'id' => $device->id->toString(),
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'CHANGE_DETECTION_DISTANCE' => [
                            'status' => false,
                            'value' => 25,
                        ],
                    ],
                ],
            ],
        };
    }
}
