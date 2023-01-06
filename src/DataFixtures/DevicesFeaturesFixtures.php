<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Core\Infrastructure\Symfony\Uuid4;
use App\Device\Application\UseCase\AddDeviceFeature\Command as AddDeviceFeatureCommand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Messenger\MessageBusInterface;

class DevicesFeaturesFixtures extends Fixture
{
    public function __construct(
        private readonly MessageBusInterface $bus,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->addDevicesFeatures();
    }

    private function addDevicesFeatures(): void
    {
        // Light bulbs
        $commandDevicesFeaturesOne = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('4d5af1d8-fe64-4868-9377-4ed325da88bb'),
            deviceId: Uuid4::fromString('0ca28ec2-e9eb-4013-a121-097c380c55bd'),
            payload: [
                'device' => [
                    'mac' => '00:00:00:00:00:00',
                    'type' => 'Light bulb',
                    'id' => '0ca28ec2-e9eb-4013-a121-097c380c55bd',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'CHANGE_COLOR_LIGHT_BULB' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('f74053a6-4f1a-4cef-b37c-1b6eb26d76ec'),
        );
        $commandDevicesFeaturesTwo = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('4c6c73f8-b985-475a-a3be-f4e3fbf8529f'),
            deviceId: Uuid4::fromString('0ca28ec2-e9eb-4013-a121-097c380c55bd'),
            payload: [
                'device' => [
                    'mac' => '00:00:00:00:00:00',
                    'type' => 'Light bulb',
                    'id' => '0ca28ec2-e9eb-4013-a121-097c380c55bd',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'CHANGE_COLOR_LIGHT_BULB' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('abfc2d09-3b51-4c34-beee-541e375b86d8'),
        );
        $commandDevicesFeaturesThree = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('860fef44-84ea-4071-8c2a-942666f097b5'),
            deviceId: Uuid4::fromString('0ca28ec2-e9eb-4013-a121-097c380c55bd'),
            payload: [
                'device' => [
                    'mac' => '00:00:00:00:00:00',
                    'type' => 'Light bulb',
                    'id' => '0ca28ec2-e9eb-4013-a121-097c380c55bd',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'CHANGE_COLOR_LIGHT_BULB' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('c3903be0-d7c6-4e8f-b959-93bb1e4f7aa6'),
        );
        $commandDevicesFeaturesFour = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('4d5af1d8-fe64-4868-9377-4ed325da88bb'),
            deviceId: Uuid4::fromString('bbf513f0-9c0b-48ac-a1a5-c47f05abe019'),
            payload: [
                'device' => [
                    'mac' => '33:33:33:33:33:33',
                    'type' => 'Light bulb',
                    'id' => 'bbf513f0-9c0b-48ac-a1a5-c47f05abe019',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'CHANGE_COLOR_LIGHT_BULB' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('4e228e58-8179-47e7-a448-fa2ef5104fac'),
        );
        $commandDevicesFeaturesFive = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('4c6c73f8-b985-475a-a3be-f4e3fbf8529f'),
            deviceId: Uuid4::fromString('bbf513f0-9c0b-48ac-a1a5-c47f05abe019'),
            payload: [
                'device' => [
                    'mac' => '33:33:33:33:33:33',
                    'type' => 'Light bulb',
                    'id' => 'bbf513f0-9c0b-48ac-a1a5-c47f05abe019',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'CHANGE_COLOR_LIGHT_BULB' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('7ac0d58d-8dd0-4b08-a777-1c0b55a6b308'),
        );
        $commandDevicesFeaturesSix = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('860fef44-84ea-4071-8c2a-942666f097b5'),
            deviceId: Uuid4::fromString('bbf513f0-9c0b-48ac-a1a5-c47f05abe019'),
            payload: [
                'device' => [
                    'mac' => '33:33:33:33:33:33',
                    'type' => 'Light bulb',
                    'id' => 'bbf513f0-9c0b-48ac-a1a5-c47f05abe019',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'CHANGE_COLOR_LIGHT_BULB' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('1acb0b73-ef27-416c-b643-f4bd44893b1e'),
        );
        // LED rings
        $commandDevicesFeaturesSeven = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('4d5af1d8-fe64-4868-9377-4ed325da88bb'),
            deviceId: Uuid4::fromString('36340076-0431-4a95-8444-69cf1f3173ec'),
            payload: [
                'device' => [
                    'mac' => '11:11:11:11:11:11',
                    'type' => 'Led ring',
                    'id' => '36340076-0431-4a95-8444-69cf1f3173ec',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('899bc67c-7166-4c9c-9c2f-57406373096d'),
        );
        $commandDevicesFeaturesEight = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('4c6c73f8-b985-475a-a3be-f4e3fbf8529f'),
            deviceId: Uuid4::fromString('36340076-0431-4a95-8444-69cf1f3173ec'),
            payload: [
                'device' => [
                    'mac' => '11:11:11:11:11:11',
                    'type' => 'Led ring',
                    'id' => '36340076-0431-4a95-8444-69cf1f3173ec',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('902e8108-cf54-4ab0-9d05-e174c8060cf4'),
        );
        $commandDevicesFeaturesNine = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('35ef3bb5-51a9-4b9b-bfc7-6afca9001759'),
            deviceId: Uuid4::fromString('36340076-0431-4a95-8444-69cf1f3173ec'),
            payload: [
                'device' => [
                    'mac' => '11:11:11:11:11:11',
                    'type' => 'Led ring',
                    'id' => '36340076-0431-4a95-8444-69cf1f3173ec',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('cb9e8557-e415-45a6-8c10-6ebebe067037'),
        );
        $commandDevicesFeaturesTen = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('99b7991d-cfc6-494b-a836-c401b18970c2'),
            deviceId: Uuid4::fromString('36340076-0431-4a95-8444-69cf1f3173ec'),
            payload: [
                'device' => [
                    'mac' => '11:11:11:11:11:11',
                    'type' => 'Led ring',
                    'id' => '36340076-0431-4a95-8444-69cf1f3173ec',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('cb9e8557-e415-45a6-8c10-6ebebe067038'),
        );
        $commandDevicesFeaturesEleven = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('99b7911d-cfc5-424b-a536-c401b18970c1'),
            deviceId: Uuid4::fromString('36340076-0431-4a95-8444-69cf1f3173ec'),
            payload: [
                'device' => [
                    'mac' => '11:11:11:11:11:11',
                    'type' => 'Led ring',
                    'id' => '36340076-0431-4a95-8444-69cf1f3173ec',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('cb9e8557-e415-45a6-8c10-6ebebe067039'),
        );
        $commandDevicesFeaturesTwelve = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('4d5af1d8-fe64-4868-9377-4ed325da88bb'),
            deviceId: Uuid4::fromString('365f42e1-4c47-4292-b788-631cb15ac7a9'),
            payload: [
                'device' => [
                    'mac' => '44:44:44:44:44:44',
                    'type' => 'Led ring',
                    'id' => '365f42e1-4c47-4292-b788-631cb15ac7a9',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('ac469891-ebc0-460c-a72d-04d9eb8c5a4d'),
        );
        $commandDevicesFeaturesThirteen = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('4c6c73f8-b985-475a-a3be-f4e3fbf8529f'),
            deviceId: Uuid4::fromString('365f42e1-4c47-4292-b788-631cb15ac7a9'),
            payload: [
                'device' => [
                    'mac' => '44:44:44:44:44:44',
                    'type' => 'Led ring',
                    'id' => '365f42e1-4c47-4292-b788-631cb15ac7a9',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('aac22987-24ed-4348-bd25-4dd0e0a7bd79'),
        );
        $commandDevicesFeaturesFourteen = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('99b7991d-cfc6-494b-a836-c401b18970c2'),
            deviceId: Uuid4::fromString('365f42e1-4c47-4292-b788-631cb15ac7a9'),
            payload: [
                'device' => [
                    'mac' => '44:44:44:44:44:44',
                    'type' => 'Led ring',
                    'id' => '365f42e1-4c47-4292-b788-631cb15ac7a9',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('87dc0f79-4739-4082-91ff-44b6b0b5a968'),
        );
        $commandDevicesFeaturesFifteen = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('35ef3bb5-51a9-4b9b-bfc7-6afca9001759'),
            deviceId: Uuid4::fromString('365f42e1-4c47-4292-b788-631cb15ac7a9'),
            payload: [
                'device' => [
                    'mac' => '44:44:44:44:44:44',
                    'type' => 'Led ring',
                    'id' => '365f42e1-4c47-4292-b788-631cb15ac7a9',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('ac469891-ebc0-460c-a72d-04d9eb8c5a4a'),
        );
        $commandDevicesFeaturesSixteen = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('99b7911d-cfc5-424b-a536-c401b18970c1'),
            deviceId: Uuid4::fromString('365f42e1-4c47-4292-b788-631cb15ac7a9'),
            payload: [
                'device' => [
                    'mac' => '44:44:44:44:44:44',
                    'type' => 'Led ring',
                    'id' => '365f42e1-4c47-4292-b788-631cb15ac7a9',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('ac469891-ebc0-460c-a72d-04d9eb8c5a4c'),
        );
        $commandDevicesFeaturesSevenTeen = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('4d5af1d8-fe64-4868-9377-4ed325da88bb'),
            deviceId: Uuid4::fromString('17a84fc0-f1e9-497b-a88b-58a0e4fe1f76'),
            payload: [
                'device' => [
                    'mac' => '55:55:55:55:55:55',
                    'type' => 'Led ring',
                    'id' => '17a84fc0-f1e9-497b-a88b-58a0e4fe1f76',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('47eb0a2e-fa7e-4d36-8839-2f2903990b23'),
        );
        $commandDevicesFeaturesEighteen = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('4c6c73f8-b985-475a-a3be-f4e3fbf8529f'),
            deviceId: Uuid4::fromString('17a84fc0-f1e9-497b-a88b-58a0e4fe1f76'),
            payload: [
                'device' => [
                    'mac' => '55:55:55:55:55:55',
                    'type' => 'Led ring',
                    'id' => '17a84fc0-f1e9-497b-a88b-58a0e4fe1f76',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('25de233a-c781-4534-895f-df4668ff42a9'),
        );
        $commandDevicesFeaturesNineteen = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('99b7991d-cfc6-494b-a836-c401b18970c2'),
            deviceId: Uuid4::fromString('17a84fc0-f1e9-497b-a88b-58a0e4fe1f76'),
            payload: [
                'device' => [
                    'mac' => '55:55:55:55:55:55',
                    'type' => 'Led ring',
                    'id' => '17a84fc0-f1e9-497b-a88b-58a0e4fe1f76',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('583d9f65-81a6-44ba-84ed-9cfeb12c7285'),
        );
        $commandDevicesFeaturesTwenty = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('35ef3bb5-51a9-4b9b-bfc7-6afca9001759'),
            deviceId: Uuid4::fromString('17a84fc0-f1e9-497b-a88b-58a0e4fe1f76'),
            payload: [
                'device' => [
                    'mac' => '55:55:55:55:55:55',
                    'type' => 'Led ring',
                    'id' => '17a84fc0-f1e9-497b-a88b-58a0e4fe1f76',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('47eb0a2e-fa7e-4d36-8839-2f2903990b24'),
        );
        $commandDevicesFeaturesTwentyOne = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('99b7911d-cfc5-424b-a536-c401b18970c1'),
            deviceId: Uuid4::fromString('17a84fc0-f1e9-497b-a88b-58a0e4fe1f76'),
            payload: [
                'device' => [
                    'mac' => '55:55:55:55:55:55',
                    'type' => 'Led ring',
                    'id' => '17a84fc0-f1e9-497b-a88b-58a0e4fe1f76',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'AMBIENT' => [
                            'status' => false,
                        ],
                        'EYE' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                        'LOADING' => [
                            'status' => false,
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('47eb0a2e-fa7e-4d36-8839-2f2903990b25'),
        );
        // Distance sensors
        $commandDevicesFeaturesTwentyTwo = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('4d5af1d8-fe64-4868-9377-4ed325da88bb'),
            deviceId: Uuid4::fromString('6e2aae94-41fc-4765-b007-46f1994d0beb'),
            payload: [
                'device' => [
                    'mac' => '22:22:22:22:22:22',
                    'type' => 'Distance sensor',
                    'id' => '6e2aae94-41fc-4765-b007-46f1994d0beb',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'CHANGE_DETECTION_DISTANCE' => [
                            'status' => false,
                            'value' => 25,
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('b332f520-d2e8-4741-9139-e718f934fcea'),
        );
        $commandDevicesFeaturesTwentyThree = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('4c6c73f8-b985-475a-a3be-f4e3fbf8529f'),
            deviceId: Uuid4::fromString('6e2aae94-41fc-4765-b007-46f1994d0beb'),
            payload: [
                'device' => [
                    'mac' => '22:22:22:22:22:22',
                    'type' => 'Distance sensor',
                    'id' => '6e2aae94-41fc-4765-b007-46f1994d0beb',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'CHANGE_DETECTION_DISTANCE' => [
                            'status' => false,
                            'value' => 25,
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('d1723660-bedb-4ed9-a7da-cc5da0823931'),
        );
        $commandDevicesFeaturesTwentyFour = new AddDeviceFeatureCommand(
            featureId: Uuid4::fromString('c76b779d-ccdb-41be-97d6-8ce857886880'),
            deviceId: Uuid4::fromString('6e2aae94-41fc-4765-b007-46f1994d0beb'),
            payload: [
                'device' => [
                    'mac' => '22:22:22:22:22:22',
                    'type' => 'Distance sensor',
                    'id' => '6e2aae94-41fc-4765-b007-46f1994d0beb',
                ],
                'actual_status' => [
                    'TURN_ON' => false,
                    'TURN_OFF' => true,
                    'features' => [
                        'CHANGE_DETECTION_DISTANCE' => [
                            'status' => false,
                            'value' => 25,
                        ],
                    ],
                ],
            ],
            id: Uuid4::fromString('84a0879d-1378-46b0-9996-512f0b4f9a4a'),
        );

        $this->bus->dispatch($commandDevicesFeaturesOne);
        $this->bus->dispatch($commandDevicesFeaturesTwo);
        $this->bus->dispatch($commandDevicesFeaturesThree);
        $this->bus->dispatch($commandDevicesFeaturesFour);
        $this->bus->dispatch($commandDevicesFeaturesFive);
        $this->bus->dispatch($commandDevicesFeaturesSix);
        $this->bus->dispatch($commandDevicesFeaturesSeven);
        $this->bus->dispatch($commandDevicesFeaturesEight);
        $this->bus->dispatch($commandDevicesFeaturesNine);
        $this->bus->dispatch($commandDevicesFeaturesTen);
        $this->bus->dispatch($commandDevicesFeaturesEleven);
        $this->bus->dispatch($commandDevicesFeaturesTwelve);
        $this->bus->dispatch($commandDevicesFeaturesThirteen);
        $this->bus->dispatch($commandDevicesFeaturesFourteen);
        $this->bus->dispatch($commandDevicesFeaturesFifteen);
        $this->bus->dispatch($commandDevicesFeaturesSixteen);
        $this->bus->dispatch($commandDevicesFeaturesSevenTeen);
        $this->bus->dispatch($commandDevicesFeaturesEighteen);
        $this->bus->dispatch($commandDevicesFeaturesNineteen);
        $this->bus->dispatch($commandDevicesFeaturesTwenty);
        $this->bus->dispatch($commandDevicesFeaturesTwentyOne);
        $this->bus->dispatch($commandDevicesFeaturesTwentyTwo);
        $this->bus->dispatch($commandDevicesFeaturesTwentyThree);
        $this->bus->dispatch($commandDevicesFeaturesTwentyFour);
    }
}
