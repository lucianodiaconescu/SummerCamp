<?php

namespace App\Form;

use App\Entity\SummerMatch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class SummerMatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('StartDate', DateType::class, [
                'label' => 'Data de start',
                'widget' => 'choice',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'attr' => ['class' => 'datepicker'],
            ])
            ->add('StartTime', TimeType::class, [
                'label' => 'Ora de start',
                'widget' => 'choice',
                'input' => 'datetime',
                'html5' => false,
                'attr' => ['class' => 'timepicker'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SummerMatch::class,
        ]);
    }
}
