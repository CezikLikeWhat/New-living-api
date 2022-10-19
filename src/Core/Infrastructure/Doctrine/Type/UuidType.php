<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Doctrine\Type;

use App\Core\Domain\Uuid;
use App\Core\Infrastructure\Symfony\Uuid4;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class UuidType extends GuidType
{
    private const NAME = 'uuid_type';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        /** @var Uuid $uuid */
        $uuid = $value;

        return $uuid->toString();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Uuid
    {
        if (null === $value) {
            return null;
        }

        /** @var string $stringValue */
        $stringValue = $value;

        return Uuid4::fromString($stringValue);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
