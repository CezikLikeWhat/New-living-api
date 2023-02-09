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
use App\Device\Domain\Exception\DeviceNotFound;
use App\Device\Domain\Exception\InvalidMACAddress;
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

    /**
     * @throws DeviceNotFound
     * @throws InvalidMACAddress
     */
    public function getDeviceInformationById(Uuid $deviceId): DeviceWithFeatures
    {
        /** @var array{
         *     id: string,
         *     name: string,
         *     device_type: string,
         *     mac_address: string,
         *     created_at: string,
         *     payload: string,
         * }|false $deviceInformation
         */
        $deviceInformation = $this->connection->fetchAssociative('
            SELECT d.id,
                   d.name, 
                   d.device_type, 
                   d.mac_address, 
                   d.created_at,
                   df.payload
            FROM devices d
            INNER JOIN devices_features df on d.id = df.device_id
            WHERE d.id = :deviceId
        ', [
            'deviceId' => $deviceId,
        ]);

        if (!is_array($deviceInformation)) {
            throw DeviceNotFound::byId($deviceId);
        }

        /** @var array{
         *     name: string,
         *     display_type: string,
         *     code_name: string
         * }[] $deviceFeatures
         */
        $deviceFeatures = $this->connection->fetchAllAssociative('
            SELECT DISTINCT f.name, 
                            f.display_type,
                            f.code_name
            FROM features f
            INNER JOIN devices_features df on f.feature_id = df.feature_id
            WHERE df.device_id = :deviceId
            ORDER BY f.code_name DESC 
        ', [
            'deviceId' => $deviceId,
        ]);

        $arrayOfFeatures = [];

        /** @var array{
         *     device: array{
         *          mac: string,
         *          type: string,
         *          id: string,
         *     },
         *     actual_status: array{
         *          TURN_ON: bool,
         *          TURN_OFF: bool,
         *          features: array<string,mixed>
         *     }
         * } $payload
         */
        $payload = json_decode($deviceInformation['payload'], true, 512, JSON_THROW_ON_ERROR);

        foreach ($deviceFeatures as $feature) {
            $arrayOfFeatures[] = new DeviceQuery\DeviceFeature(
                $feature['name'],
                $feature['display_type'],
                $feature['code_name'],
            );
            if ('TURN_ON' !== $feature['code_name'] && 'TURN_OFF' !== $feature['code_name']) {
                /** @phpstan-ignore-next-line
                 *  @psalm-suppress MixedArrayAssignment
                 */
                $payload['actual_status']['features'][$feature['code_name']]['display_type'] = $feature['display_type'];
            }
        }

        return new DeviceWithFeatures(
            Uuid4::fromString($deviceInformation['id']),
            $deviceInformation['name'],
            DeviceType::fromString($deviceInformation['device_type']),
            new MACAddress($deviceInformation['mac_address']),
            \DateTimeImmutable::createFromFormat('Y-m-d', $deviceInformation['created_at']),
            $payload,
            $arrayOfFeatures
        );
    }
}
