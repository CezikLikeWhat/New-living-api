<?php

declare(strict_types=1);

namespace App\Tests\User\Domain;

use App\Core\Domain\Email;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\Tests\DoctrineTestCase;
use App\User\Domain\Exception\UserException;
use App\User\Domain\User;

class UserTest extends DoctrineTestCase
{
    /** @dataProvider provideValidFirstNameAndLastName */
    public function testThatPersonalDataAreValid(string $firstName, string $lastName): void
    {
        // Will fail if contructor of User class throws an exception
        new User(
            Uuid4::generateNew(),
            '104785794615508114589',
            $firstName,
            $lastName,
            new Email('test@gmail.com'),
            $this->clock()->now(),
            ['ROLE_USER']
        );

        self::assertTrue(true);
    }

    /** @dataProvider provideInvalidFirstNameAndLastName */
    public function testThatFirstNameOrLastNameIsEmpty(string $firstName, string $lastName): void
    {
        $this->expectException(UserException::class);
        new User(
            Uuid4::generateNew(),
            '104785794615508114589',
            $firstName,
            $lastName,
            new Email('test@gmail.com'),
            $this->clock()->now(),
            ['ROLE_USER']
        );
        self::assertTrue(true);
    }

    public function provideValidFirstNameAndLastName(): array
    {
        return [
            ['John', 'Doe'],
            [' John', ' Doe'],
            ['John ', 'Doe'],
            [' John', 'Doe '],
            ["John\t", 'Doe'],
        ];
    }

    public function provideInvalidFirstNameAndLastName(): array
    {
        return [
            ['John', ''],
            ['', 'Doe'],
            ['', ''],
        ];
    }
}
