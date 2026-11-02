<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Measurement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => function (Location $location) {
                    return $location->getCity() . ' (' . $location->getCountry() . ')';
                },
                'label' => 'Lokalizacja',
                'placeholder' => 'Wybierz lokalizację',
            ])

            ->add('date', DateType::class, [
                'label' => 'Data pomiaru',
                'widget' => 'single_text',
            ])

            ->add('celsius', NumberType::class, [
                'label' => 'Temperatura (°C)',
                'input' => 'string',
                'scale' => 0,
                'html5' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }
}

