<?php

declare(strict_types=1);

namespace App\User\Application\UseCase;

use App\User\Application\UseCase\Exceptions\UserNotFound;
use App\User\Domain\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ChangeFirstAndLastName
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @throws UserNotFound
     */
    public function __invoke(ChangeFirstAndLastName\Command $command): void
    {
        $user = $this->userRepository->findBySystemId($command->userID);

        if (!$user) {
            throw UserNotFound::bySystemId($command->userID);
        }

        $user->setFirstName($command->firstName);
        $user->setLastName($command->lastName);
    }
}
