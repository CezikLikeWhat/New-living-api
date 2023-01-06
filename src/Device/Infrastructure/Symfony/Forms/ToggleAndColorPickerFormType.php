<?php

declare(strict_types=1);

namespace App\Device\Infrastructure\Symfony\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToggleAndColorPickerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var array<mixed> $featureOptions */
        $featureOptions = $options['featureOptions'];

        /** @var string $featureName */
        $featureName = $options['featureName'];

        $builder->add('enable', CheckboxType::class, [
            'label_attr' => [
                'class' => 'checkbox-switch',
                'hidden' => true,
            ],
            'attr' => [
                'class' => 'custom-toggle feature-toggle',
                'data-type' => $featureName,
            ],
            'data' => $featureOptions['status'],
            'required' => false,
        ])
            ->add('colorPicker', ColorType::class, [
                'label_attr' => [
                    'hidden' => true,
                ],
                'attr' => [
                    'class' => 'form-control color-picker',
                    'type' => 'color',
                    'data-type' => 'color-picker',
                    'data-set-type' => $featureName,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired([
            'featureOptions',
            'featureName',
        ]);
    }
}
