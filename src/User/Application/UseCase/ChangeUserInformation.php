<?php

declare(strict_types=1);

namespace App\User\Application\UseCase;

use App\Core\Domain\Exception\EmailException;
use App\User\Application\UseCase\Exceptions\UserNotFound;
use App\User\Domain\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ChangeUserInformation
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @throws UserNotFound
     * @throws EmailException
     */
    public function __invoke(ChangeUserInformation\Command $command): void
    {
        $user = $this->userRepository->findBySystemId($command->userId);
        if (!$user) {
            throw UserNotFound::bySystemId($command->userId);
        }

        if ($user->firstName() !== $command->firstName) {
            $user->setFirstName($command->firstName);
        }
        if ($user->lastName() !== $command->lastName) {
            $user->setLastName($command->lastName);
        }
        if ($user->email() !== $command->email()->value()) {
            $user->setEmail($command->email());
        }
    }
}
