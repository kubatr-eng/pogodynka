<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                'label' => 'Miasto',
                'attr' => [
                    'placeholder' => 'Wprowadź nazwę miasta',
                ],
            ])

            ->add('country', ChoiceType::class, [
                'label' => 'Państwo',
                'placeholder' => 'Wybierz państwo',
                'choices' => [
                    'Poland' => 'PL',
                    'Germany' => 'DE',
                    'Romania' => 'RO',
                    'Ireland' => 'IE',
                    'France' => 'FR',
                    'Sweden' => 'SE',
                    'Norway' => 'NO',
                ],
            ])

            ->add('latitude', NumberType::class, [
                'label' => 'Szerokość geograficzna',
                'input' => 'string',
                'scale' => 7,
                'html5' => false,
            ])

            ->add('longitude', NumberType::class, [
                'label' => 'Długość geograficzna',
                'input' => 'string',
                'scale' => 7,
                'html5' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
