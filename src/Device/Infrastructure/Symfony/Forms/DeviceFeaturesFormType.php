<?php

declare(strict_types=1);

namespace App\Device\Infrastructure\Symfony\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;

class DeviceFeaturesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var array<mixed> $payload */
        $payload = $options['payload'];

        $builder->add('TURN_ON', CheckboxType::class, [
            'label_attr' => [
                'class' => 'checkbox-switch',
                'hidden' => true,
            ],
            'attr' => [
                'class' => 'custom-toggle turn-toggle',
            ],
            'data' => $payload['actual_status']['TURN_ON'],
            'required' => false,
        ])
        ->add('TURN_OFF', CheckboxType::class, [
            'label_attr' => [
                'class' => 'checkbox-switch',
                'hidden' => true,
            ],
            'attr' => [
                'class' => 'custom-toggle turn-toggle',
            ],
            'data' => $payload['actual_status']['TURN_OFF'],
            'required' => false,
        ]);

        /** @var array<string,mixed> $arrayOfFeatures */
        $arrayOfFeatures = $payload['actual_status']['features'];
        foreach ($arrayOfFeatures as $featureName => $featureOptions) {
            switch ($featureOptions['display_type']) {
                case 'toggle':
                    $builder->add($featureName, CheckboxType::class, [
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
                    ]);
                    break;
                case 'input':
                    $builder->add($featureName, NumberType::class, [
                        'label_attr' => [
                            'class' => 'form-floating',
                            'hidden' => true,
                        ],
                        'attr' => [
                            'class' => 'custom-input',
                        ],
                        'required' => false,
                        'constraints' => [
                            new Positive(),
                        ],
                    ]);
                    break;
                default:
                    $builder->add($featureName, ToggleAndColorPickerFormType::class, [
                        'featureName' => $featureName,
                        'featureOptions' => $featureOptions,
                    ]);
            }
        }
        $builder->add('submit', SubmitType::class, [
            'label' => 'Submit',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'POST',
        ])
            ->setRequired([
                'payload',
            ]);
    }
}
