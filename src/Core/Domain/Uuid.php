<?php

declare(strict_types=1);

namespace App\Core\Domain;

interface Uuid extends \JsonSerializable
{
    public static function fromString(string $uuid): self;

    public static function generateNew(): self;

    public function toString(): string;

    public function __toString(): string;

    public function isEqual(Uuid $uuid): bool;
}
