<?php

declare(strict_types=1);

namespace App\Mailer\Infrastructure\Symfony\Mailer;

use App\Core\Domain\Email;
use App\Mailer\Application\EmailSender;
use App\Mailer\Application\MailingClient;
use App\Mailer\Domain\EmailSchema;
use App\Mailer\Domain\TemplateProperties;

class SymfonyEmailSender implements EmailSender
{
    public function __construct(
        private readonly MailingClient $mailingClient,
        private readonly string $senderEmailAddress,
    ) {
    }

    public function sendGreetingEmail(string $firstName, Email $recipient): void
    {
        $schema = new EmailSchema(
            sender: new Email($this->senderEmailAddress),
            recipient: new Email($recipient->value()),
            subject: sprintf('%s, welcome to the system!', $firstName),
            templateProperties: new TemplateProperties(
                templatePath: 'Mailer/greeting_email.html.twig',
                params: [
                    'firstName' => $firstName,
                ]
            )
        );

        $this->mailingClient->sendTemplatedEmail($schema);
    }

    public function sendErrorEmail(string $firstName, Email $recipient, string $deviceName): void
    {
        $schema = new EmailSchema(
            sender: new Email($this->senderEmailAddress),
            recipient: new Email($recipient->value()),
            subject: sprintf('Device error(%s)', $deviceName),
            templateProperties: new TemplateProperties(
                templatePath: 'Mailer/device_error_email.html.twig',
                params: [
                    'firstName' => $firstName,
                    'device' => $deviceName,
                ]
            )
        );

        $this->mailingClient->sendTemplatedEmail($schema);
    }
}
