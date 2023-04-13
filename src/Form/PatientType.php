<?php

namespace App\Form;

use App\Entity\Indigent;
use App\Entity\Patient;
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

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('middleName')
            ->add('lastName')
            ->add('gender', ChoiceType::class,["choices" => ["Select sex"=>null,"Male" => "M","Female"=>"F"]])
            ->add('emr')
         //   ->add('phone')
           // ->add('dob')
            ->add('address')
           ->add('indigent')


            // ->add('indigent', EntityType::class, [
            //     'class' =>Indigent::class,
            //     'required'=>false,
            //     'query_builder' => function (EntityRepository $err) {
            //         $result = $err->createQueryBuilder('e')
                 
            //                ->orderBy('e.name', 'ASC');   
    
                     
            //         return $result;
            //     },
            
            //     'placeholder' => "Select indigent",
            // ])


            ->add('woreda')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
