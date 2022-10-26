<?php

declare(strict_types=1);

namespace App\Mailer\Domain;

class TemplateProperties
{
    /**
     * @param array<string,mixed> $params
     */
    public function __construct(
        public readonly string $templatePath,
        public readonly array $params
    ) {
    }
}
