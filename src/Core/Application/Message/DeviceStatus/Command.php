<?php

declare(strict_types=1);

namespace App\Core\Application\Message\DeviceStatus;

class Command
{
    /**
     * @param array{
     *     device: array{
     *          id: string,
     *          type: string,
     *          mac: string,
     *     },
     *     actual_status: array<mixed>,
     * } $message
     */
    public function __construct(
        public readonly array $message
    ) {
    }
}
