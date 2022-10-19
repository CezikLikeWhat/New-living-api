<?php

declare(strict_types=1);

namespace App\Core\Domain\Exception;

class EmailException extends \Exception
{
    public static function byCorrectness(string $email): self
    {
        return new self(
            sprintf('Email: %s is not valid', $email)
        );
    }
}
