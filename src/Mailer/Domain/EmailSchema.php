<?php

declare(strict_types=1);

namespace App\Mailer\Domain;

use App\Core\Domain\Email;

class EmailSchema
{
    public function __construct(
        public readonly Email $sender,
        public readonly Email $recipient,
        public readonly string $subject,
        public readonly TemplateProperties $templateProperties
    ) {
    }
}
