<?php

declare(strict_types=1);

namespace App\Tests\Core\Application\Query;

use App\Core\Application\Query\DeviceQuery\Device;
use App\Core\Domain\Uuid;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\Device\Domain\DeviceType;
use App\Device\Domain\MACAddress;
use App\Tests\DoctrineTestCase;

class DeviceQueryTest extends DoctrineTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->addDevice(
            userId: Uuid4::fromString('c3809d87-3bee-4771-b285-8ed327837c0d'),
            name: 'Distance sensor - front door',
            deviceType: DeviceType::DISTANCE_SENSOR,
            macAddress: new MACAddress('5F:75:1A:69:85:F2'),
            id: Uuid4::fromString('eb7a109e-21b3-4bfa-a342-3bbc0b40c02c'),
        );
        $this->addDevice(
            userId: Uuid4::fromString('af49b9aa-89d7-4a24-9010-c23806831e0a'),
            name: 'Led strip behind TV',
            deviceType: DeviceType::LED_STRIP,
            macAddress: new MACAddress('0A:AE:B9:A3:8F:04'),
            id: Uuid4::fromString('2355ee99-75c4-45e9-9485-2637be030649'),
        );
        $this->addDevice(
            userId: Uuid4::fromString('f04c7c84-c849-4bb1-b036-73551dad2079'),
            name: 'Light bulb - kitchen',
            deviceType: DeviceType::LIGHT_BULB,
            macAddress: new MACAddress('4A:73:E3:57:1B:E0'),
            id: Uuid4::fromString('e16b879d-46a1-48f3-9fdc-eff238606801'),
        );
        $this->addDevice(
            userId: Uuid4::fromString('c3809d87-3bee-4771-b285-8ed327837c0d'),
            name: 'Light bulb - office',
            deviceType: DeviceType::LIGHT_BULB,
            macAddress: new MACAddress('12:66:C5:ED:85:79'),
            id: Uuid4::fromString('e26f188a-340d-464f-a529-3b8d7bddf9cf'),
        );
    }

    /** @dataProvider provideUserIdAndUserDevices */
    public function testGetAllDevicesByUserId(Uuid $id, array $expectedDevices): void
    {
        $actualUserDevices = $this->deviceQuery()->getAllDevicesByUserId($id);

        for ($i = 0, $iMax = count($actualUserDevices); $i < $iMax; ++$i) {
            self::assertEquals($expectedDevices[$i]->id, $actualUserDevices[$i]->id);
            self::assertEquals($expectedDevices[$i]->name, $actualUserDevices[$i]->name);
            self::assertEquals($expectedDevices[$i]->deviceType, $actualUserDevices[$i]->deviceType);
            self::assertEquals($expectedDevices[$i]->macAddress, $actualUserDevices[$i]->macAddress);
        }
    }

    public function provideUserIdAndUserDevices(): array
    {
        return [
            [
                Uuid4::fromString('c3809d87-3bee-4771-b285-8ed327837c0d'),
                [
                    new Device(
                        id: Uuid4::fromString('eb7a109e-21b3-4bfa-a342-3bbc0b40c02c'),
                        name: 'Distance sensor - front door',
                        deviceType: DeviceType::DISTANCE_SENSOR,
                        macAddress: new MACAddress('5F:75:1A:69:85:F2'),
                        createdAt: new \DateTimeImmutable('23-10-2022'),
                    ),
                    new Device(
                        id: Uuid4::fromString('e26f188a-340d-464f-a529-3b8d7bddf9cf'),
                        name: 'Light bulb - office',
                        deviceType: DeviceType::LIGHT_BULB,
                        macAddress: new MACAddress('12:66:C5:ED:85:79'),
                        createdAt: new \DateTimeImmutable('15-10-2022'),
                    ),
                ],
            ],
            [
                Uuid4::fromString('af49b9aa-89d7-4a24-9010-c23806831e0a'),
                [
                    new Device(
                        id: Uuid4::fromString('2355ee99-75c4-45e9-9485-2637be030649'),
                        name: 'Led strip behind TV',
                        deviceType: DeviceType::LED_STRIP,
                        macAddress: new MACAddress('0A:AE:B9:A3:8F:04'),
                        createdAt: new \DateTimeImmutable('22-10-2022'),
                    ),
                ],
            ],
            [
                Uuid4::fromString('f04c7c84-c849-4bb1-b036-73551dad2079'),
                [
                    new Device(
                        id: Uuid4::fromString('e16b879d-46a1-48f3-9fdc-eff238606801'),
                        name: 'Light bulb - kitchen',
                        deviceType: DeviceType::LIGHT_BULB,
                        macAddress: new MACAddress('4A:73:E3:57:1B:E0'),
                        createdAt: new \DateTimeImmutable('10-10-2022'),
                    ),
                ],
            ],
        ];
    }
}
