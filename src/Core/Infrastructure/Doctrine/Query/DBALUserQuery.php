<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Doctrine\Query;

use App\Core\Application\Query\UserQuery;
use App\Core\Domain\Email;
use App\Core\Domain\Uuid;
use App\Device\Domain\DeviceType;
use App\Device\Domain\MACAddress;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

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
            SELECT u.first_name, u.last_name, u.email
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
         *     name: string,
         *     device_type: string,
         *     mac_address: string,
         *     created_at: string
         * }[] $data
         */
        $data = $this->connection->fetchAllAssociative('
            SELECT d.name, d.device_type, d.mac_address, d.created_at
            FROM devices d
            WHERE d.user_id = :userId
            ORDER BY d.created_at
        ', [
            'userId' => $id->toString(),
        ]);

        return array_map(static fn (array $device) => new UserQuery\Device(
            name: $device['name'],
            deviceType: DeviceType::fromString($device['device_type']),
            macAddress: new MACAddress($device['mac_address']),
            createdAt: \DateTimeImmutable::createFromFormat('Y-m-d', $device['created_at']) ?: new DateTimeImmutable()
        ), $data);
    }
}
