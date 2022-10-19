<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Doctrine\Type;

use App\Core\Domain\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class EmailType extends Type
{
    private const NAME = 'email_type';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'VARCHAR(320)';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->value();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email
    {
        return new Email($value) ?? null;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}