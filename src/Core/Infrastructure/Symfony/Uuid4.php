<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Symfony;

use App\Core\Domain\Uuid;
use Symfony\Component\Uid\UuidV4;

class Uuid4 implements Uuid
{
    private function __construct(
        private readonly UuidV4 $uuid,
    ) {
    }

    public static function fromString(string $uuid): Uuid
    {
        return new self(UuidV4::fromString($uuid));
    }

    public static function generateNew(): Uuid
    {
        return new self(new UuidV4());
    }

    public function toString(): string
    {
        return $this->uuid->toRfc4122();
    }

    public function isEqual(Uuid $uuid): bool
    {
        return $this->toString() === $uuid->toString();
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function jsonSerialize(): mixed
    {
        return $this->toString();
    }
}
