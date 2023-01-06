<?php

declare(strict_types=1);

namespace App\User\Application\UseCase\ChangeUserInformation;

use App\Core\Domain\Email;
use App\Core\Domain\Exception\EmailException;
use App\Core\Domain\Uuid;

class Command
{
    public function __construct(
        public readonly Uuid $userId,
        public readonly string $firstName,
        public readonly string $lastName,
        private readonly string $email,
    ) {
    }

    /**
     * @throws EmailException
     */
    public function email(): Email
    {
        return new Email($this->email);
    }
}
