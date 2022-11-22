<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Core\Infrastructure\Symfony\Uuid4;
use App\Device\Application\UseCase\AddDevice\Command as AddDeviceCommand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Messenger\MessageBusInterface;

class DevicesFixtures extends Fixture
{
    public function __construct(
        private readonly MessageBusInterface $bus,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->addDevices();
    }

    private function addDevices(): void
    {
        $commandDeviceOne = new AddDeviceCommand(
            userId: Uuid4::fromString('6444fa16-a42b-49fc-83ba-0019e596ded0'),
            name: 'Light bulb - living room',
            deviceType: 'Light bulb',
            macAddress: '00:00:00:00:00:00',
            id: Uuid4::fromString('0ca28ec2-e9eb-4013-a121-097c380c55bd')
        );

        $commandDeviceTwo = new AddDeviceCommand(
            userId: Uuid4::fromString('6444fa16-a42b-49fc-83ba-0019e596ded0'),
            name: 'Led strip - tv',
            deviceType: 'Led strip',
            macAddress: '11:11:11:11:11:11',
            id: Uuid4::fromString('36340076-0431-4a95-8444-69cf1f3173ec')
        );

        $commandDeviceThree = new AddDeviceCommand(
            userId: Uuid4::fromString('6444fa16-a42b-49fc-83ba-0019e596ded0'),
            name: 'Distance sensor - patio',
            deviceType: 'Distance sensor',
            macAddress: '22:22:22:22:22:22',
            id: Uuid4::fromString('6e2aae94-41fc-4765-b007-46f1994d0beb')
        );

        $commandDeviceFour = new AddDeviceCommand(
            userId: Uuid4::fromString('7b85810c-2ad4-4ce2-b088-f0bf2b5bd3c9'),
            name: 'Light bulb - kitchen',
            deviceType: 'Light bulb',
            macAddress: '33:33:33:33:33:33',
        );

        $commandDeviceFive = new AddDeviceCommand(
            userId: Uuid4::fromString('7b85810c-2ad4-4ce2-b088-f0bf2b5bd3c9'),
            name: 'Led strip - office desk',
            deviceType: 'Led strip',
            macAddress: '44:44:44:44:44:44',
            id: Uuid4::fromString('365f42e1-4c47-4292-b788-631cb15ac7a9')
        );

        $commandDeviceSix = new AddDeviceCommand(
            userId: Uuid4::fromString('217aa4b9-5fb0-45c6-afff-81894f7af357'),
            name: 'Camera sensor - front entrance',
            deviceType: 'Distance sensor',
            macAddress: '55:55:55:55:55:55',
            id: Uuid4::fromString('17a84fc0-f1e9-497b-a88b-58a0e4fe1f76')
        );

        $this->bus->dispatch($commandDeviceOne);
        $this->bus->dispatch($commandDeviceTwo);
        $this->bus->dispatch($commandDeviceThree);
        $this->bus->dispatch($commandDeviceFour);
        $this->bus->dispatch($commandDeviceFive);
        $this->bus->dispatch($commandDeviceSix);
    }
}
