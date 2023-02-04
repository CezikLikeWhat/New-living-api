<?php

declare(strict_types=1);

namespace App\Core\Application\FormParser;

use App\Core\Domain\Uuid;
use App\Device\Domain\DeviceType;
use App\Device\Domain\Exception\DeviceFeatureNotFound;
use App\Device\Domain\Exception\DeviceNotFound;
use App\Device\Domain\Exception\FeatureNotFound;
use App\Device\Domain\Repository\DeviceFeatureRepository;
use App\Device\Domain\Repository\DeviceRepository;
use App\Device\Domain\Repository\FeatureRepository;

class FormParser
{
    public function __construct(
        private readonly DeviceFeatureRepository $deviceFeatureRepository,
        private readonly FeatureRepository $featureRepository,
        private readonly DeviceRepository $deviceRepository,
    ) {
    }

    /**
     * @param array<mixed> $formData
     *
     * @return array<mixed>
     */
    public function parseChangeFeatureForm(Uuid $deviceId, array $formData): array
    {
        $feature = $this->featureRepository->findByCodeName('TURN_OFF');
        if (!$feature) {
            throw FeatureNotFound::byCodeName('TURN_OFF');
        }

        $deviceFeature = $this->deviceFeatureRepository->findByFeatureIdAndDeviceId($feature->id, $deviceId);
        if (!$deviceFeature) {
            throw DeviceFeatureNotFound::byFeatureAndDeviceId($feature->id, $deviceId);
        }

        $device = $this->deviceRepository->findById($deviceId);
        if (!$device) {
            throw DeviceNotFound::byId($deviceId);
        }

        $finalArray = $deviceFeature->payload;

        $options = [
            'change' => [
                'mode' => '',
                'options' => [],
            ],
        ];

        if ($formData['TURN_OFF']) {
            $options['change']['mode'] = 'TURN_OFF';

            return array_merge($finalArray, $options);
        }

        switch ($device->deviceType) {
            case DeviceType::LIGHT_BULB:
                /** @var string $lightBulbColor */
                $lightBulbColor = !$formData['CHANGE_COLOR_LIGHT_BULB']['colorPicker'] ? '#000000' : $formData['CHANGE_COLOR_LIGHT_BULB']['colorPicker'];
                if ($deviceFeature->payload['actual_status']['features']['CHANGE_COLOR_LIGHT_BULB']['color'] !== $lightBulbColor) {
                    $options['change']['mode'] = 'CHANGE_COLOR_LIGHT_BULB';
                    $options['change']['options']['color'] = $lightBulbColor;
                    break;
                }
                break;
            case DeviceType::LED_RING:
                if (($deviceFeature->payload['actual_status']['features']['AMBIENT']['status'] !== $formData['AMBIENT']) &&
                    !$formData['EYE']['enable'] && !$formData['LOADING']['enable']
                ) {
                    $options['change']['mode'] = 'AMBIENT';
                    break;
                }
                if (
                    ($deviceFeature->payload['actual_status']['features']['EYE']['status'] !== $formData['EYE']['enable'] && !$formData['AMBIENT'] && !$formData['LOADING']['enable']) ||
                        (
                            $deviceFeature->payload['actual_status']['features']['EYE']['status'] &&
                            (
                                $formData['EYE']['enable'] &&
                                ($deviceFeature->payload['actual_status']['features']['EYE']['color'] !== $formData['EYE']['colorPicker'])
                            )
                        )
                ) {
                    /** @var string $color */
                    $color = !$formData['EYE']['colorPicker'] ? '#000000' : $formData['EYE']['colorPicker'];
                    $options['change']['mode'] = 'EYE';
                    $options['change']['options']['color'] = $color;
                    break;
                }
                if (
                    ($deviceFeature->payload['actual_status']['features']['LOADING']['status'] !== $formData['LOADING']['enable'] && !$formData['AMBIENT'] && !$formData['EYE']['enable']) ||
                        (
                            $deviceFeature->payload['actual_status']['features']['LOADING']['status'] &&
                            (
                                $formData['LOADING']['enable'] &&
                                ($deviceFeature->payload['actual_status']['features']['LOADING']['color'] !== $formData['LOADING']['colorPicker'])
                            )
                        )
                ) {
                    /** @var string $color */
                    $color = !$formData['LOADING']['colorPicker'] ? '#000000' : $formData['LOADING']['colorPicker'];
                    $options['change']['mode'] = 'LOADING';
                    $options['change']['options']['color'] = $color;
                    break;
                }
                break;
            case DeviceType::DISTANCE_SENSOR:
                /** @var int $distanceDetection */
                $distanceDetection = !$formData['CHANGE_DETECTION_DISTANCE'] ? 25 : $formData['CHANGE_DETECTION_DISTANCE'];
                if ($deviceFeature->payload['actual_status']['features']['CHANGE_DETECTION_DISTANCE']['value'] !== $distanceDetection) {
                    $options['change']['mode'] = 'CHANGE_DETECTION_DISTANCE';
                    $options['change']['options']['detection_distance'] = $distanceDetection;
                    break;
                }
                break;
        }

        return array_merge($finalArray, $options);
    }
}
