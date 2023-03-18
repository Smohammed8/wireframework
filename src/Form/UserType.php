<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

     
        $role=[
            "System Adminstrator"=>"ROLE_ADMIN",
            "Data encoder" => "ROLE_DATA_ENCODER",
            "Manager" => "ROLE_MANAGER",
    
        ];

        $builder
        
        ->add('roles', ChoiceType::class,["choices" => $role,'mapped'=>false,"multiple"=>true,"placeholder"=>"Select Role"])
           
     
           // ->add('username')
         
          //  ->add('password')
            ->add('firstName')
            ->add('fatherName')
           // ->add('phone')
        
            ->add('gender', ChoiceType::class,["choices" => ["Select sex"=>null,"Male" => "M","Female"=>"F"]])
            
            ->add('email')
          //  ->add('lastLogin')
          //  ->add('status')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
