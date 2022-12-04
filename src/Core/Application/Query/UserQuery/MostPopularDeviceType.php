<?php

declare(strict_types=1);

namespace App\Core\Application\Query\UserQuery;

class MostPopularDeviceType
{
    public function __construct(
        public readonly string $type,
        public readonly int $quantity,
    ) {
    }
}
