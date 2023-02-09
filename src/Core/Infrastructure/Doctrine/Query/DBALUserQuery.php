<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Doctrine\Query;

use App\Core\Application\Query\UserQuery;
use App\Core\Domain\Email;
use App\Core\Domain\Uuid;
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

    public function getNumberOfAllUsers(): int
    {
        /** @var array{ number_of_users: int } $data */
        $data = $this->connection->fetchAssociative('
            SELECT COUNT(users.id) as number_of_users
            FROM users
        ');

        return $data['number_of_users'];
    }
}
