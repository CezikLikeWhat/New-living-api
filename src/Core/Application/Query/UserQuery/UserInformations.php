<?php

declare(strict_types=1);

namespace App\Core\Application\Query\UserQuery;

use App\Core\Domain\Email;

class UserInformations implements \JsonSerializable
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly Email $email,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email
        ];
    }
}