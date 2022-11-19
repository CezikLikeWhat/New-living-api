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
            userId: Uuid4::fromString('6444fa16-a42b-49fc-83ba-0019e596ded0'),
            roles: ['ROLE_USER', 'ROLE_ADMIN']
        );
        $commandUserTwo = new AddUserCommand(
            googleId: '924215204619508124581',
            firstName: 'Ryszard',
            lastName: 'Kowalski',
            email: 'ryszardkowalski76@gmail.com',
            userId: Uuid4::fromString('217aa4b9-5fb0-45c6-afff-81894f7af357'),
            roles: ['ROLE_USER']
        );
        $commandUserThree = new AddUserCommand(
            googleId: '420213769619508124281',
            firstName: 'Magdalena',
            lastName: 'Pamiątka',
            email: 'madzia2000@gmail.com',
            userId: Uuid4::fromString('7b85810c-2ad4-4ce2-b088-f0bf2b5bd3c9'),
            roles: ['ROLE_USER']
        );

        $this->bus->dispatch($commandUserOne);
        $this->bus->dispatch($commandUserTwo);
        $this->bus->dispatch($commandUserThree);
    }
}
