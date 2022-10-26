<?php

declare(strict_types=1);

namespace App\Mailer\Application;

use App\Core\Domain\Email;

interface EmailSender
{
    public function sendGreetingEmail(string $firstName, Email $recipient): void;

    public function sendErrorEmail(string $firstName, Email $recipient, string $deviceName): void;
}
