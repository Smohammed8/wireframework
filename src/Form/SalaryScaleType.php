<?php

namespace App\Form;

use App\Entity\SalaryScale;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalaryScaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startSalary')
            ->add('one')
            ->add('two')
            ->add('three')
            ->add('four')
            ->add('five')
            ->add('six')
            ->add('seven')
            ->add('eight')
            ->add('nine')
            ->add('ceilSalary')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('level')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SalaryScale::class,
        ]);
    }
}
