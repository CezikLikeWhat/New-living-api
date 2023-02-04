<?php

declare(strict_types=1);

namespace App\Core\Application\Query\DeviceQuery;

class DeviceFeature implements \JsonSerializable
{
    public function __construct(
        public readonly string $featureName,
        public readonly string $displayType,
        public readonly string $codeName,
    ) {
    }

    /**
     * @return array<string, string>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->featureName,
            'displayType' => $this->displayType,
            'codeName' => $this->codeName,
        ];
    }
}
