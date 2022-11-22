<?php

declare(strict_types=1);

namespace App\Tests\Core\Domain;

use App\Core\Domain\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testThatTwoEmailsAreEquals(): void
    {
        $emailOne = new Email('test1234@gmail.com');
        $emailTwo = new Email('test1234@gmail.com');

        self::assertTrue($emailOne->isEqual($emailTwo));
    }

    public function testThatTwoEmailsAreNotEquals(): void
    {
        $emailOne = new Email('test1234@gmail.com');
        $emailTwo = new Email('test123@gmail.com');

        self::assertFalse($emailOne->isEqual($emailTwo));
    }

    /** @dataProvider provideValidEmails */
    public function testThatValidEmailsAreValid(string $email): void
    {
        self::assertTrue(Email::isValid($email));
    }

    /** @dataProvider provideInvalidEmails */
    public function testThatInvalidEmailsAreInvalid(string $email): void
    {
        self::assertFalse(Email::isValid($email));
    }

    public function provideValidEmails(): array
    {
        return [
            ['test@gmail.com'],
            ['valid.email@gmail.com'],
            ['onet@onet.pl'],
            ['janusz.nowak@wp.pl'],
            ['proton@proton.pl'],
        ];
    }

    public function provideInvalidEmails(): array
    {
        return [
            ['2gmail.com'],
            ['email@.gmail'],
            ['gmail.com@'],
            ['www.test@pl.wp'],
            ['2test123@@gmail.com'],
        ];
    }
}
