<?php

namespace App\Form;

use App\Entity\EmployeeLanguage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeLanguageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('speaking')
            ->add('reading')
            ->add('writing')
            ->add('listening')
            ->add('employee')
            ->add('language')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EmployeeLanguage::class,
        ]);
    }
}
