<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Doctrine\Query;

use App\Core\Application\Query\Exceptions\DeviceTypeCannotBeFound;
use App\Core\Application\Query\UserQuery;
use App\Core\Application\Query\UserQuery\MostPopularDeviceType;
use App\Core\Domain\Email;
use App\Core\Domain\Uuid;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\Device\Domain\DeviceType;
use App\Device\Domain\MACAddress;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use InvalidArgumentException;

class DBALUserQuery implements UserQuery
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function getAllUserInformationsByUserId(Uuid $id): UserQuery\UserInformations
    {
        /** @var array{
         *     first_name: string,
         *     last_name: string,
         *     email: string,
         * } $data
         */
        $data = $this->connection->fetchAssociative('
            SELECT u.first_name, 
                   u.last_name,
                   u.email
            FROM users u
            WHERE u.id = :userId
        ', [
            'userId' => $id->toString(),
        ]);

        return new UserQuery\UserInformations(
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            email: new Email($data['email']),
        );
    }

    public function getAllUserDevicesByUserId(Uuid $id): array
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

        return array_map(static fn (array $device) => new UserQuery\Device(
            id: Uuid4::FromString($device['id']),
            name: $device['name'],
            deviceType: DeviceType::fromString($device['device_type']),
            macAddress: new MACAddress($device['mac_address']),
            createdAt: \DateTimeImmutable::createFromFormat('Y-m-d', $device['created_at']) ?: new DateTimeImmutable()
        ), $data);
    }

    public function getMostPopularUserDevicesType(Uuid $id): MostPopularDeviceType
    {
        /** @var array{
         *     id: string,
         *     device_type: string
         * }[] $data
         */
        $data = $this->connection->fetchAllAssociative('
            SELECT d.id, d.device_type
            FROM devices d
            WHERE d.user_id = :userID
        ', [
            'userID' => $id,
        ]);

        if(!$data){
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
        $deviceType = array_search($quantity,$counterArray,true);

        return new MostPopularDeviceType($deviceType, $quantity);
    }

    public function getNumberOfAllUsers(): int
    {
        /** @var array{ number_of_devices: int } $data */
        $data = $this->connection->fetchAssociative('
            SELECT COUNT(d.id) as number_of_devices
            FROM devices d
        ');

        return $data['number_of_devices'];
    }

    public function getMostPopularDevicesType(): MostPopularDeviceType
    {
        /** @var array{
         *     id: string,
         *     device_type: string
         * }[] $data
         */
        $data = $this->connection->fetchAllAssociative('
            SELECT d.id, d.device_type
            FROM devices d
        ');

        if(!$data){
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
}
