<?php

declare(strict_types=1);

namespace App\User\Application\UseCase;

use App\Core\Domain\Email;
use App\Core\Domain\Exception\EmailException;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\User\Application\UseCase\AddUser\Command;
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
    public function __invoke(Command $command): void
    {
        $user = new User(
            Uuid4::generateNew(),
            $command->googleId,
            $command->firstName,
            $command->lastName,
            new Email($command->email),
            $command->devices,
            $command->roles
        );

        $this->userRepository->add($user);
    }
}
