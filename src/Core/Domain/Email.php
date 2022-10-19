<?php

declare(strict_types=1);

namespace App\Core\Domain;

use App\Core\Domain\Exception\EmailException;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;

class Email implements \JsonSerializable
{

    public function __construct(
        private string $email
    ) {
        $emailAfterTrim = trim($email);
        $preparedEmail = mb_strtolower($emailAfterTrim, 'UTF-8');

        if (!self::isValid($preparedEmail)) {
            throw EmailException::byCorrectness($preparedEmail);
        }

        $this->email = $preparedEmail;
    }

    public static function isValid(string $email): bool
    {
        $validator = new EmailValidator();

        $validations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation(),
        ]);

        return $validator->isValid($email, $validations);
    }

    public function value(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function isEqual(Email $email): bool
    {
        return $this->email === $email->value();
    }

    /**
     * @return array{email: string}
     */
    public function jsonSerialize(): array
    {
        return [
            'email' => $this->email
        ];
    }
}