<?php

declare(strict_types=1);

namespace App\User\Application\UseCase\ChangeEmail;

use App\Core\Domain\Email;
use App\Core\Domain\Exception\EmailException;
use App\Core\Domain\Uuid;

class Command
{
    public function __construct(
        public readonly Uuid $userID,
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
