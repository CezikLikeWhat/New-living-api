<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Symfony\Forms;

use App\Core\Application\Query\UserQuery\UserInformations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class GeneralProfileInformationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var UserInformations $userInfo */
        $userInfo = $options['userInfo'];

        $builder
            ->add('firstName', TextType::class, [
                'trim' => true,
                'label' => 'First name',
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'text',
                    'name' => 'firstName',
                    'value' => $userInfo->firstName,
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('lastName', TextType::class, [
                'trim' => true,
                'label' => 'Last name',
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'text',
                    'name' => 'lastName',
                    'value' => $userInfo->lastName,
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('email', TextType::class, [
                'trim' => true,
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'text',
                    'name' => 'email',
                    'value' => $userInfo->email->value(),
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'POST',
        ])
            ->setRequired('userInfo');
    }
}
