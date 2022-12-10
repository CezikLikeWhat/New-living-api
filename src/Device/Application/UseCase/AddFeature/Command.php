<?php

declare(strict_types=1);

namespace App\Device\Application\UseCase\AddFeature;

use App\Core\Domain\Uuid;

class Command
{
    public function __construct(
        public readonly string $name,
        public readonly string $codeName,
        public readonly string $displayType,
        public readonly ?Uuid $id = null,
    ) {
    }
}