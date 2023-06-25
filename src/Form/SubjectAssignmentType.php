<?php

namespace App\Form;

use App\Entity\SubjectAssignment;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class SubjectAssignmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
         
              ->add('section')
         
               ->add('subject')
               ->add('teacher', EntityType::class, [
                   'class' => User::class,
                   'query_builder' => function (EntityRepository $er) {
                       $res = $er->createQueryBuilder('u')
                           ->andWhere("u.roles LIKE '%ROLE_TEACHER%'")
                           //->orWhere("u.roles LIKE '%EMS_NURSE%'")
                           ->orderBy('u.firstName', 'ASC');
                       return $res;
                   },
               
                   'placeholder' => "Select teacher as head...",
               ])
   
   
            //    ->add('year', TextType::class, [
            //        'attr' => ['readonly' => true],
            //    ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SubjectAssignment::class,
        ]);
    }
}
