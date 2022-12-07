<?php

declare(strict_types=1);

namespace App\User\Application\UseCase\ChangeFirstAndLastName;

use App\Core\Domain\Uuid;

class Command
{
    public function __construct(
        public readonly Uuid $userID,
        public readonly string $firstName,
        public readonly string $lastName,
    ) {
    }
}
