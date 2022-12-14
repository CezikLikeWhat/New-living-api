<?php

declare(strict_types=1);

namespace App\Mailer\Application;

use App\Mailer\Domain\EmailSchema;

interface MailingClient
{
    public function sendTemplatedEmail(EmailSchema $schema): void;
}
