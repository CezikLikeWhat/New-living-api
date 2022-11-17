<?php

declare(strict_types=1);

namespace App\User\Application\UseCase;

use App\Core\Domain\Email;
use App\Core\Domain\Exception\EmailException;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\User\Domain\Exception\UserException;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AddUser
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @throws UserException
     * @throws EmailException
     */
    public function __invoke(AddUser\Command $command): void
    {
        $user = new User(
            id: $command->userId ?? Uuid4::generateNew(),
            googleId: $command->googleId,
            firstName: $command->firstName,
            lastName: $command->lastName,
            email: new Email($command->email),
            roles: $command->roles
        );

        $this->userRepository->add($user);
    }
}
