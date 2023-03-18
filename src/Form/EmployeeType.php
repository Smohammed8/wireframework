<?php

namespace App\Form;

use App\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('fatherName')
            ->add('lastName')
            ->add('gender')
            ->add('dateOfBirth')
            ->add('phone')
            ->add('birthPlace')
            ->add('photo')
            ->add('bloodGroup')
            ->add('eyeColor')
            ->add('email')
            ->add('idNumber')
            ->add('pentionNumber')
            ->add('createdAt')
            ->add('firstNameAm')
            ->add('fatherNameAm')
            ->add('lastNameAm')
            ->add('updatedAt')
            ->add('employementDate')
            ->add('employeeTitle')
            ->add('educationallevel')
            ->add('martitalStatus')
            ->add('ethnicity')
            ->add('religion')
            ->add('fieldOfStudy')
            ->add('employmentType')
            ->add('employeeCurrentStatus')
            ->add('nationality')
            ->add('employeeCategory')
            ->add('position')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
