<?php

declare(strict_types=1);

namespace App\Device\Application\UseCase;

use App\Core\Infrastructure\Symfony\Uuid4;
use App\Device\Domain\Feature;
use App\Device\Domain\Repository\FeatureRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AddFeature
{
    public function __construct(
        private readonly FeatureRepository $featureRepository,
    ) {
    }

    public function __invoke(AddFeature\Command $command): void
    {
        $feature = new Feature(
            id: $command->id ?: Uuid4::generateNew(),
            name: $command->name,
            codeName: $command->codeName,
            displayType: $command->displayType
        );
        $this->featureRepository->add($feature);
    }
}