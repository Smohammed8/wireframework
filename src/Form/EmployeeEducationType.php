<?php

namespace App\Form;

use App\Entity\EmployeeEducation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeEducationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('institution')
            ->add('startDate')
            ->add('endDate')
            ->add('file')
            ->add('employee')
            ->add('educationLevel')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EmployeeEducation::class,
        ]);
    }
}
