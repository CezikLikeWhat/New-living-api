<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Doctrine\Query;

use App\Core\Application\Query\DeviceQuery;
use App\Core\Application\Query\DeviceQuery\Device;
use App\Core\Application\Query\DeviceQuery\DeviceWithFeatures;
use App\Core\Application\Query\DeviceQuery\MostPopularDeviceType;
use App\Core\Domain\Uuid;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\Device\Domain\DeviceType;
use App\Device\Domain\MACAddress;
use Doctrine\DBAL\Connection;

class DBALDeviceQuery implements DeviceQuery
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function getAllDevicesByUserId(Uuid $id): array
    {
        /** @var array{
         *     id: string,
         *     name: string,
         *     device_type: string,
         *     mac_address: string,
         *     created_at: string
         * }[] $data
         */
        $data = $this->connection->fetchAllAssociative('
            SELECT d.id, 
                   d.name, 
                   d.device_type,
                   d.mac_address,
                   d.created_at
            FROM devices d
            WHERE d.user_id = :userId
            ORDER BY d.created_at
        ', [
            'userId' => $id->toString(),
        ]);

        return array_map(static fn (array $device) => new Device(
            id: Uuid4::FromString($device['id']),
            name: $device['name'],
            deviceType: DeviceType::fromString($device['device_type']),
            macAddress: new MACAddress($device['mac_address']),
            createdAt: \DateTimeImmutable::createFromFormat('Y-m-d', $device['created_at']) ?: new \DateTimeImmutable()
        ), $data);
    }

    public function getMostPopularDeviceTypeByUserId(Uuid $id): MostPopularDeviceType
    {
        /** @var array{
         *     id: string,
         *     device_type: string
         * }[] $data
         */
        $data = $this->connection->fetchAllAssociative('
            SELECT d.id, 
                   d.device_type
            FROM devices d
            WHERE d.user_id = :userID
        ', [
            'userID' => $id,
        ]);

        if (!$data) {
            return new MostPopularDeviceType('', 0);
        }

        /** @var non-empty-array<string, int> $counterArray */
        $counterArray = [];
        foreach ($data as $device) {
            if (!array_key_exists($device['device_type'], $counterArray)) {
                $counterArray[$device['device_type']] = 1;
                continue;
            }
            ++$counterArray[$device['device_type']];
        }

        $quantity = max($counterArray);
        /** @var string $deviceType */
        $deviceType = array_search($quantity, $counterArray, true);

        return new MostPopularDeviceType($deviceType, $quantity);
    }

    public function getMostPopularDeviceType(): MostPopularDeviceType
    {
        /** @var array{
         *     id: string,
         *     device_type: string
         * }[] $data
         */
        $data = $this->connection->fetchAllAssociative('
            SELECT d.id, 
                   d.device_type
            FROM devices d
        ');

        if (!$data) {
            return new MostPopularDeviceType('', 0);
        }

        /** @var non-empty-array<string, int> $counterArray */
        $counterArray = [];
        foreach ($data as $device) {
            if (!array_key_exists($device['device_type'], $counterArray)) {
                $counterArray[$device['device_type']] = 1;
                continue;
            }
            ++$counterArray[$device['device_type']];
        }

        $quantity = max($counterArray);
        /** @var string $deviceType */
        $deviceType = array_search($quantity, $counterArray, true);

        return new MostPopularDeviceType($deviceType, $quantity);
    }

    public function getDeviceInformationById(Uuid $deviceId): DeviceWithFeatures
    {
        /** @var array{
         *     device_name: string,
         *     device_type: string,
         *     mac_address: string,
         *     created_at: string,
         *     payload: string,
         *     feature_name: string,
         *     display_type: string
         * } $deviceInformation
         */
        $deviceInformation = $this->connection->fetchAssociative('
            SELECT d.name as device_name, 
                   d.device_type, 
                   d.mac_address, 
                   d.created_at
            FROM devices d
            WHERE d.id = :deviceId
        ', [
            'deviceId' => $deviceId,
        ]);

        /** @var array{
         *     payload: string,
         *     name: string,
         *     display_type: string,
         * }[] $deviceFeatures
         */
        $deviceFeatures = $this->connection->fetchAllAssociative('
            SELECT df.payload,
                   f.name, 
                   f.display_type
            FROM devices_features df
            INNER JOIN features f on df.feature_id = f.feature_id
            WHERE df.device_id = :deviceId
        ', [
            'deviceId' => $deviceId,
        ]);

        $arrayOfFeatures = [];

        foreach ($deviceFeatures as $feature) {
            /** @var array<mixed> $payload */
            $payload = json_decode($feature['payload'], true, 512, JSON_THROW_ON_ERROR);
            $arrayOfFeatures[] = [
                'feature_name' => $feature['name'],
                'display_type' => $feature['display_type'],
                'payload' => $payload,
            ];
        }

        return new DeviceWithFeatures(
            $deviceInformation['device_name'],
            DeviceType::fromString($deviceInformation['device_type']),
            new MACAddress($deviceInformation['mac_address']),
            new \DateTimeImmutable($deviceInformation['created_at']),
            $arrayOfFeatures,
        );
    }
}
