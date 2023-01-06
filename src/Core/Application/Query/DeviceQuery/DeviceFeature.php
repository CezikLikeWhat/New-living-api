<?php

declare(strict_types=1);

namespace App\Core\Application\Query\DeviceQuery;

class DeviceFeature
{
    public function __construct(
        public readonly string $featureName,
        public readonly string $displayType,
        public readonly string $codeName,
    ) {
    }
}
