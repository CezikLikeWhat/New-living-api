<?php

declare(strict_types=1);

namespace App\Tests\Core\Application\Query;

use App\Core\Application\Query\UserQuery;
use App\Core\Domain\Email;
use App\Core\Domain\Uuid;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\Tests\DoctrineTestCase;

class UserQueryTest extends DoctrineTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->addUser(
            googleId: '924215204619508124581',
            firstName: 'Alex',
            lastName: 'Bechtelar',
            email: new Email('alex.bechtelar@gmail.com'),
            userId: Uuid4::fromString('c3809d87-3bee-4771-b285-8ed327837c0d'),
            roles: ['USER_ROLE']
        );
        $this->addUser(
            googleId: '634215224611508224111',
            firstName: 'Perry',
            lastName: 'Kautzer',
            email: new Email('perry.kautzer@gmail.com'),
            userId: Uuid4::fromString('af49b9aa-89d7-4a24-9010-c23806831e0a'),
            roles: ['USER_ROLE']
        );
        $this->addUser(
            googleId: '827217207617502123585',
            firstName: 'Robin',
            lastName: 'Thiel',
            email: new Email('robin.thiel@gmail.com'),
            userId: Uuid4::fromString('f04c7c84-c849-4bb1-b036-73551dad2079'),
            roles: ['USER_ROLE']
        );
    }

    /** @dataProvider provideUserIdAndUserInformations */
    public function testGetAllUserInformationById(Uuid $id, UserQuery\UserInformations $expectedUserInformations): void
    {
        $actualUserInformation = $this->userQuery()->getAllUserInformationsByUserId($id);

        self::assertEquals($expectedUserInformations, $actualUserInformation);
    }

    public function provideUserIdAndUserInformations(): array
    {
        return [
            [
                Uuid4::fromString('c3809d87-3bee-4771-b285-8ed327837c0d'),
                new UserQuery\UserInformations(
                    firstName: 'Alex',
                    lastName: 'Bechtelar',
                    email: new Email('alex.bechtelar@gmail.com'),
                ),
            ],
            [
                Uuid4::fromString('af49b9aa-89d7-4a24-9010-c23806831e0a'),
                new UserQuery\UserInformations(
                    firstName: 'Perry',
                    lastName: 'Kautzer',
                    email: new Email('perry.kautzer@gmail.com'),
                ),
            ],
            [
                Uuid4::fromString('f04c7c84-c849-4bb1-b036-73551dad2079'),
                new UserQuery\UserInformations(
                    firstName: 'Robin',
                    lastName: 'Thiel',
                    email: new Email('robin.thiel@gmail.com'),
                ),
            ],
        ];
    }
}
