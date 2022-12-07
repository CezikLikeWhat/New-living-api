<?php

declare(strict_types=1);

namespace App\User\Application\UseCase;

use App\Core\Domain\Exception\EmailException;
use App\User\Application\UseCase\Exceptions\UserNotFound;
use App\User\Domain\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ChangeEmail
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @throws UserNotFound
     * @throws EmailException
     */
    public function __invoke(ChangeEmail\Command $command): void
    {
        $user = $this->userRepository->findBySystemId($command->userID);

        if (!$user) {
            throw UserNotFound::bySystemId($command->userID);
        }

        $user->setEmail($command->email());
    }
}
