<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\Core\Domain\Email;
use App\Core\Domain\Uuid;
use App\User\Domain\User;

interface UserRepository
{
    public function add(User $user): void;

    public function findByEmail(Email $email): ?User;

    public function findByGoogleId(string $userID): ?User;

    public function findBySystemId(Uuid $userID): ?User;
}
