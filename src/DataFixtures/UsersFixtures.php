<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Core\Infrastructure\Symfony\Uuid4;
use App\User\Application\UseCase\AddUser\Command as AddUserCommand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Messenger\MessageBusInterface;

class UsersFixtures extends Fixture
{

    public function __construct(
        private readonly MessageBusInterface $bus,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->addUsers();
    }

    private function addUsers(): void
    {
        $commandUserOne = new AddUserCommand(
            googleId: '104215204619508124589',
            firstName: 'Cezary',
            lastName: 'Maćkowski',
            email: 'cezary.mackowski@gmail.com',
            devices: [
                Uuid4::fromString('0ca28ec2-e9eb-4013-a121-097c380c55bd'),
                Uuid4::fromString('36340076-0431-4a95-8444-69cf1f3173ec'),
                Uuid4::fromString('6e2aae94-41fc-4765-b007-46f1994d0beb')
            ],
            roles: ['ROLE_USER', 'ROLE_ADMIN']
        );
        $commandUserTwo = new AddUserCommand(
            googleId: '924215204619508124581',
            firstName: 'Ryszard',
            lastName: 'Kowalski',
            email: 'ryszardkowalski76@gmail.com',
            devices: [
                Uuid4::fromString('17a84fc0-f1e9-497b-a88b-58a0e4fe1f76'),

            ],
            roles: ['ROLE_USER']
        );
        $commandUserThree = new AddUserCommand(
            googleId: '420213769619508124281',
            firstName: 'Magdalena',
            lastName: 'Pamiątka',
            email: 'madzia2000@gmail.com',
            devices: [
                Uuid4::fromString('365f42e1-4c47-4292-b788-631cb15ac7a9')
            ],
            roles: ['ROLE_USER']
        );

        $this->bus->dispatch($commandUserOne);
        $this->bus->dispatch($commandUserTwo);
        $this->bus->dispatch($commandUserThree);
    }
}