<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

class UserException extends \Exception
{
    public static function byEmptyProperty(string $propertyName): self
    {
        return new self(
            sprintf('Empty property: %s', $propertyName)
        );
    }

    public static function byInvalidFormat(string $property, string $value): self
    {
        return new self(
            sprintf(
                'Invalid format by property: %s and value: %s',
                $property,
                $value
            )
        );
    }
}
