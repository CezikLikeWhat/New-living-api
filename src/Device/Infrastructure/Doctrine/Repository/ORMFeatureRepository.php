<?php

declare(strict_types=1);

namespace App\Device\Infrastructure\Doctrine\Repository;

use App\Core\Domain\Uuid;
use App\Device\Domain\Feature;
use App\Device\Domain\Repository\FeatureRepository;
use Doctrine\Persistence\ManagerRegistry;

class ORMFeatureRepository implements FeatureRepository
{
    public function __construct(
        private readonly ManagerRegistry $registry,
    ) {
    }

    public function add(Feature $feature): void
    {
        $this->registry->getManager()->persist($feature);
    }

    public function findById(Uuid $featureId): ?Feature
    {
        return $this->registry
            ->getRepository(Feature::class)
            ->findOneBy(['id' => $featureId]);
    }
}
