<?php

declare(strict_types=1);

namespace App\Tests;

use App\Core\Application\Query\UserQuery;
use App\Core\Domain\Clock;
use App\Core\Domain\Clock\TestClock;
use App\Core\Domain\Email;
use App\Core\Domain\Uuid;
use App\Device\Application\UseCase\AddDevice\Command as AddDeviceCommand;
use App\User\Application\UseCase\AddUser\Command as AddUserCommand;
use App\Device\Domain\DeviceType;
use App\Device\Domain\MACAddress;
use App\Device\Domain\Repository\DeviceRepository;
use App\User\Domain\Repository\UserRepository;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class DoctrineTestCase extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var ManagerRegistry $doctrine
         */
        $doctrine = static::getContainer()->get('doctrine');

        (new ORMPurger($doctrine->getManager()))->purge();
        $this->clock()->setCurrentDateTime(null);
    }

    protected function messageBus(): MessageBusInterface
    {
        return static::getContainer()->get(MessageBusInterface::class);
    }

    protected function clock(): TestClock
    {
        /** @var TestClock $clock */
        $clock = static::getContainer()->get(Clock::class);

        return $clock;
    }

    protected function userRepository(): UserRepository
    {
        return static::getContainer()->get(UserRepository::class);
    }

    protected function deviceRepository(): DeviceRepository
    {
        return static::getContainer()->get(DeviceRepository::class);
    }

    protected function userQuery(): UserQuery
    {
        return static::getContainer()->get(UserQuery::class);
    }

    protected function addDevice(
        Uuid $userId,
        string $name,
        DeviceType $deviceType,
        MACAddress $macAddress,
        ?Uuid $id,
    ): void
    {
        $this->messageBus()->dispatch(new AddDeviceCommand(
            userId: $userId,
            name: $name,
            deviceType: $deviceType->value,
            macAddress: (string) $macAddress,
            id: $id
        ));
    }

    protected function addUser(
        string $googleId,
        string $firstName,
        string $lastName,
        Email $email,
        ?Uuid $userId,
        array $roles
    ): void
    {
        $this->messageBus()->dispatch(new AddUserCommand(
            googleId: $googleId,
            firstName: $firstName,
            lastName: $lastName,
            email: $email->value(),
            userId: $userId,
            roles: $roles
        ));
    }
}
