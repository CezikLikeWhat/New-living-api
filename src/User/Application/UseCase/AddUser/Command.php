<?php

declare(strict_types=1);

namespace App\User\Application\UseCase\AddUser;

use App\Core\Domain\Uuid;

class Command
{
    /**
     * @param string[] $roles
     */
    public function __construct(
        public readonly string $googleId,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly ?Uuid $userId = null,
        public readonly array $roles = ['ROLE_USER'],
    ) {
    }
}
