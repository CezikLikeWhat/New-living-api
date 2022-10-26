<?php

declare(strict_types=1);

namespace App\Mailer\Infrastructure\Symfony\Mailer;

use App\Mailer\Application\MailingClient;
use App\Mailer\Domain\EmailSchema;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class SymfonyMailingClient implements MailingClient
{
    public function __construct(
        private readonly MailerInterface $mailer,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendTemplatedEmail(EmailSchema $schema): void
    {
        $email = (new TemplatedEmail())
            ->from($schema->sender->value())
            ->to($schema->recipient->value())
            ->subject($schema->subject)
            ->htmlTemplate($schema->templateProperties->templatePath)
            ->context($schema->templateProperties->params);

        $this->mailer->send($email);
    }
}
