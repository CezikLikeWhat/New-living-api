<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Symfony;

use Symfony\Component\Form\FormInterface;

final class FormErrorCatcher
{
    /**
     * @return array<string,mixed>
     */
    public static function getFormErrors(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            /**
             * @psalm-suppress MixedAssignment, PossiblyUndefinedMethod
             */
            $errors[$form->getName()][] = $error->getMessage();
        }

        foreach ($form as $child) {
            if ($child->isSubmitted() && !$child->isValid()) {
                foreach ($child->getErrors() as $error) {
                    /**
                     * @psalm-suppress MixedAssignment, PossiblyUndefinedMethod
                     */
                    $errors[$child->getName()][] = $error->getMessage();
                }
            }
        }

        return $errors;
    }
}
