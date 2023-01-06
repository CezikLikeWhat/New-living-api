<?php

declare(strict_types=1);

namespace App\Device\Domain\Repository;

use App\Core\Domain\Uuid;
use App\Device\Domain\Feature;

interface FeatureRepository
{
    public function add(Feature $feature): void;

    public function findById(Uuid $featureId): ?Feature;

    public function findByCodeName(string $codeName): ?Feature;
}
