<?php

namespace App\Form;

use App\Entity\StudentLeave;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentLeaveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate')
            ->add('endDate')
            ->add('status')
            ->add('createdAt')
            ->add('approvedAt')
            ->add('leaveType')
            ->add('student')
            ->add('user')
            ->add('approvedBy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StudentLeave::class,
        ]);
    }
}
