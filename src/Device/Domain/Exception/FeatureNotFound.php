<?php

declare(strict_types=1);

namespace App\Device\Domain\Exception;

class FeatureNotFound extends \Exception
{
    public static function byCodeName(string $featureCodeName): self
    {
        return new self(
            sprintf('Feature with code name: %s not found', $featureCodeName)
        );
    }
}
