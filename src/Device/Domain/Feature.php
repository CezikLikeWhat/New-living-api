<?php

declare(strict_types=1);

namespace App\Device\Domain;

use App\Core\Domain\Uuid;

class Feature
{
    public function __construct(
        public readonly Uuid $id,
        public readonly string $name,
        public readonly string $codeName,
        public readonly string $displayType,
    ) {
    }
}