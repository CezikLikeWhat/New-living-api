<?php

declare(strict_types=1);

namespace App\User\Application\UseCase\Exceptions;

use App\Core\Domain\Uuid;

class UserNotFound extends \Exception
{
    public static function bySystemId(Uuid $id): self
    {
        return new self(
            sprintf('User with id: %s not found', $id)
        );
    }
}
