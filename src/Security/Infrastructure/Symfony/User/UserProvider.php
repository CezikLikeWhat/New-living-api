<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\User;

use App\User\Domain\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        $userTakenFromDatabase = $this->userRepository->findByGoogleId($user->getUserIdentifier());

        if (!$userTakenFromDatabase) {
            throw new UserNotFoundException();
        }

        if ($userTakenFromDatabase->googleIdentifier() !== $user->getUserIdentifier()) {
            throw new UserNotFoundException();
        }

        return new User(
            $userTakenFromDatabase->googleIdentifier(),
            $userTakenFromDatabase->email(),
            $userTakenFromDatabase->roles()
        );
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        throw new UserNotFoundException();
    }
}
