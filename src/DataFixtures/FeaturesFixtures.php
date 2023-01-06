<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Core\Infrastructure\Symfony\Uuid4;
use App\Device\Application\UseCase\AddFeature\Command as AddFeatureCommand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Messenger\MessageBusInterface;

class FeaturesFixtures extends Fixture
{
    public function __construct(
        private readonly MessageBusInterface $bus,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->addFeatures();
    }

    private function addFeatures(): void
    {
        $commandFeatureOne = new AddFeatureCommand(
            name: 'Turn off',
            codeName: 'TURN_OFF',
            displayType: 'toggle',
            id: Uuid4::fromString('4d5af1d8-fe64-4868-9377-4ed325da88bb'),
        );
        $commandFeatureTwo = new AddFeatureCommand(
            name: 'Turn on',
            codeName: 'TURN_ON',
            displayType: 'toggle',
            id: Uuid4::fromString('4c6c73f8-b985-475a-a3be-f4e3fbf8529f'),
        );
        $commandFeatureThree = new AddFeatureCommand(
            name: 'Change motion detection distance(cm)',
            codeName: 'CHANGE_DETECTION_DISTANCE',
            displayType: 'input',
            id: Uuid4::fromString('c76b779d-ccdb-41be-97d6-8ce857886880'),
        );
        $commandFeatureFour = new AddFeatureCommand(
            name: 'Change the color of the light bulb',
            codeName: 'CHANGE_COLOR_LIGHT_BULB',
            displayType: 'toggle_and_colorpicker',
            id: Uuid4::fromString('860fef44-84ea-4071-8c2a-942666f097b5'),
        );
        $commandFeatureFive = new AddFeatureCommand(
            name: 'Enable ambient mode on LED ring',
            codeName: 'AMBIENT',
            displayType: 'toggle',
            id: Uuid4::fromString('99b7991d-cfc6-494b-a836-c401b18970c2'),
        );
        $commandFeatureSix = new AddFeatureCommand(
            name: 'Enable eye effect on LED ring',
            codeName: 'EYE',
            displayType: 'toggle_and_colorpicker',
            id: Uuid4::fromString('35ef3bb5-51a9-4b9b-bfc7-6afca9001759'),
        );
        $commandFeatureSeven = new AddFeatureCommand(
            name: 'Enable loading effect on LED ring',
            codeName: 'LOADING',
            displayType: 'toggle_and_colorpicker',
            id: Uuid4::fromString('99b7911d-cfc5-424b-a536-c401b18970c1'),
        );

        $this->bus->dispatch($commandFeatureOne);
        $this->bus->dispatch($commandFeatureTwo);
        $this->bus->dispatch($commandFeatureThree);
        $this->bus->dispatch($commandFeatureFour);
        $this->bus->dispatch($commandFeatureFive);
        $this->bus->dispatch($commandFeatureSix);
        $this->bus->dispatch($commandFeatureSeven);
    }
}
