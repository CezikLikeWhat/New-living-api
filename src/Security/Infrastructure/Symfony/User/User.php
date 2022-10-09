<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\User;

use Symfony\Component\Security\Core\Exception\InvalidArgumentException;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /**
     * @param string[] $roles
     */
    public function __construct(
        private readonly string $id,
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly string $email,
        private array $roles,
    ) {
        if (!$firstName || ctype_space($this->firstName)) {
            throw new InvalidArgumentException('User first name is empty');
        }
        if (!$lastName || ctype_space($this->lastName)) {
            throw new InvalidArgumentException('User last name is empty');
        }
        if (!$email || ctype_space($this->email)) {
            throw new InvalidArgumentException('User email is empty');
        }
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function addRole(string $newRole): void
    {
        $roles = $this->roles;

        $roles[] = $newRole;

        $this->roles = array_unique($roles);
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->id;
    }
}
