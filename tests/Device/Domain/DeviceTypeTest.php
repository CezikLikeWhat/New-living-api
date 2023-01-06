<?php

declare(strict_types=1);

namespace App\Tests\Device\Domain;

use App\Device\Domain\DeviceType;
use PHPUnit\Framework\TestCase;
use ValueError;

class DeviceTypeTest extends TestCase
{
    /** @dataProvider provideValidDeviceTypeString */
    public function testThatCreatingDeviceTypeFromStringWillNotFail(string $deviceType): void
    {
        // Will fail if fromString method of DeviceType enum throws any exception
        DeviceType::fromString($deviceType);
        self::assertTrue(true);
    }

    /** @dataProvider provideInvalidDeviceTypeString */
    public function testThatCreatingDeviceTypeFromStringWillFail(string $deviceType): void
    {
        $this->expectException(ValueError::class);

        DeviceType::fromString($deviceType);
    }

    public function provideValidDeviceTypeString(): array
    {
        return [
            ['Light bulb'],
            ['Led ring'],
            ['Distance sensor'],
        ];
    }

    public function provideInvalidDeviceTypeString(): array
    {
        return [
            ['TestDevice'],
            ['Device123'],
            ['3D Printer'],
            ['Big Red Bulb'],
            ['IR sensor'],
        ];
    }
}
