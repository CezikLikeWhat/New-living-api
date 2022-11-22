<?php

declare(strict_types=1);

namespace App\Tests\Device\Domain;

use App\Device\Domain\Exception\InvalidMACAddress;
use App\Device\Domain\MACAddress;
use PHPUnit\Framework\TestCase;

class MACAddressTest extends TestCase
{
    /** @dataProvider provideValidMacAddresses */
    public function testThatMacAddressesAreValid(string $macAddress): void
    {
        // Will fail if contructor of MACAddress class throws an exception
        new MACAddress($macAddress);
        self::assertTrue(true);
    }

    /** @dataProvider provideInvalidMacAddresses */
    public function testThatMacAddressesAreInvalid(string $macAddress): void
    {
        $this->expectException(InvalidMACAddress::class);

        new MACAddress($macAddress);
    }

    public function provideValidMacAddresses(): array
    {
        return [
            ['AA:AA:AA:AA:AA:AA'],
            ['22:22:22:22:22:22'],
            ['EA-EA-EA-EA-EA-EA'],
            ['5E:2F:6C:7B:11:3A'],
            ['01-23-45-67-89-AB'],
        ];
    }

    public function provideInvalidMacAddresses(): array
    {
        return [
            ['AA:AA:AA:AA:AA'],
            ['GA:AA:AA:AA:AA:AA'],
            ['123:AA:AA:AA:AA:AA'],
            ['AE:22:33:ER:AA:DD'],
            ['123:123:123:123:123:123'],
        ];
    }
}
