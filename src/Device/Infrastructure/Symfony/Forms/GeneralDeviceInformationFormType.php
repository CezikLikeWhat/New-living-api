<?php

declare(strict_types=1);

namespace App\Device\Infrastructure\Symfony\Forms;

use App\Core\Application\Query\DeviceQuery\DeviceWithFeatures;
use App\Device\Domain\DeviceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class GeneralDeviceInformationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var DeviceWithFeatures $device */
        $device = $options['device'];

        $builder
            ->add('deviceName', TextType::class, [
                'trim' => true,
                'label' => 'Device name',
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'text',
                    'name' => 'deviceName',
                    'value' => $device->name ?? '',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('deviceType', EnumType::class, [
                'class' => DeviceType::class,
                'choice_label' => static fn (DeviceType $deviceType) => $deviceType->value,
                'data' => $device->type ?? null,
                'label' => 'Device type',
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'select',
                    'name' => 'deviceType',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('deviceMacAddress', TextType::class, [
                'trim' => true,
                'label' => 'Device MAC address',
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'text',
                    'name' => 'deviceMacAddress',
                    'value' => $device->macAddress ?? null,
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
            'csrf_protection' => false,
        ])
            ->setRequired([
                'device',
            ]);
    }
}
