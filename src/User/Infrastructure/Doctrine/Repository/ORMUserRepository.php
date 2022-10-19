<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Repository;

use App\User\Domain\Repository\UserRepository;
use App\User\Domain\User;
use Doctrine\Persistence\ManagerRegistry;

class ORMUserRepository implements UserRepository
{
    public function __construct(
        private readonly ManagerRegistry $registry,
    ) {
    }

    public function add(User $user): void
    {
        $this->registry->getManager()->persist($user);
    }

    public function findByGoogleId(string $userID): ?User
    {
        return $this->registry
            ->getRepository(User::class)
            ->findOneBy(['googleId' => $userID]);
    }
}
