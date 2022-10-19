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

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        /** @var Email $email */
        $email = $value;
        return $email->value();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Email
    {
        /** @var string $email */
        $email = $value;
        return new Email($email);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
