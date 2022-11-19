<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\User;

use App\Core\Domain\Uuid;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /**
     * @param string[] $roles
     */
    public function __construct(
        private readonly Uuid $id,
        private readonly string $googleId,
        private readonly string $email,
        private array $roles,
    ) {
        if (!$email || ctype_space($this->email)) {
            throw new InvalidArgumentException('User email is empty');
        }
    }

    public function systemIdentifier(): Uuid
    {
        return $this->id;
    }

    public function email(): string
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
        return $this->googleId;
    }
}
