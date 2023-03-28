<?php

namespace App\Form;

use App\Entity\PayrollSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PayrollSettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('incomeStart')
            ->add('incomeTo')
            ->add('incomeTax')
            ->add('deduction')
            ->add('pension')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PayrollSetting::class,
        ]);
    }
}
