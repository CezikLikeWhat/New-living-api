<?php

declare(strict_types=1);

namespace App\User\Application\UseCase\AddUser;

use App\Core\Domain\Uuid;

class Command
{
    /**
     * @param Uuid[] $devices
     * @param string[] $roles
     */
    public function __construct(
        public readonly string $googleId,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly array $devices = [],
        public readonly array $roles = ['ROLE_USER'],
    ) {
    }
}
