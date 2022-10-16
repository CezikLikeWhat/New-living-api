<?php

declare(strict_types=1);

namespace App\Device\Domain;

use App\Device\Domain\Exception\InvalidMACAddress;

final class MACAddress implements \JsonSerializable
{
    /**
     * @throws InvalidMACAddress
     */
    public function __construct(
        private readonly string $address,
    ) {
        if(false === filter_var($this->address, FILTER_VALIDATE_MAC)){
            throw InvalidMACAddress::byFormat($this->address);
        }
    }

    public function __toString(): string
    {
        return $this->address;
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}