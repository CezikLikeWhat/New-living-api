<?php

declare(strict_types=1);

namespace App\Core\Application\Message\ChangeParameter;

class Command
{
    /**
     * @param array<mixed> $json
     */
    public function __construct(
        public readonly array $json
    ) {
    }
}
