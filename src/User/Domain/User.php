<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\Core\Domain\Email;
use App\Core\Domain\Uuid;
use App\Device\Domain\Device;
use App\User\Domain\Exception\UserException;

class User
{
    /**
     * @param Uuid[] $devices
     * @param string[] $roles
     *
     * @throws UserException
     */
    public function __construct(
        private readonly Uuid $id,
        private readonly string $googleId,
        private string $firstName,
        private string $lastName,
        private Email $email,
        private array $devices,
        private array $roles,
    ) {
        if (!$firstName || ctype_space($this->firstName)) {
            throw UserException::byEmptyProperty('first name');
        }
        if (!$lastName || ctype_space($this->lastName)) {
            throw UserException::byEmptyProperty('last name');
        }
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function googleIdentifier(): string
    {
        return $this->googleId;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): string
    {
        return $this->lastName = $lastName;
    }

    public function email(): string
    {
        return $this->email->value();
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    /**
     * @return Uuid[]
     */
    public function devices(): array
    {
        return $this->devices;
    }

    public function addDevice(Device $device): void
    {
        $this->devices[] = $device->id;
    }

    /**
     * @return string[]
     */
    public function roles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function addRole(string $newRole): void
    {
        $roles = $this->roles;

        $roles[] = $newRole;

        $this->roles = array_unique($roles);
    }

    public function eraseCredentials(): void
    {
    }
}
