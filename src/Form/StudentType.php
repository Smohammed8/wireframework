<?php
namespace App\Form;
use App\Entity\Country;
use App\Entity\Student;
use App\Entity\Woreda;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('fatherName')
            ->add('lastName')
            ->add('gender', ChoiceType::class,["choices" => ["-"=>null,"Male" => "M","Female"=>"F"]])
            //->add('dob')
      
            ->add('photo', FileType::class, array('data_class' => null, 'required' => false))

            ->add('nationality', EntityType::class, [
                'class' =>Country::class,
                'required'=>true,
                'attr'=>[
                    'class'=>'form-control  select2'
                    ],
                'query_builder' => function (EntityRepository $err) {
                    $result = $err->createQueryBuilder('e')
                 
                           ->orderBy('e.nationality', 'ASC');   
    
                     
                    return $result;
                },
            
                'placeholder' => "Select nationality",
            ])

            ->add('birthPlace')
            ->add('currentAddress')
            ->add('email')
            ->add('phone')
            ->add('houseNumber')
        
            ->add('maritalStatus', ChoiceType::class,["choices" => ["Select marital status"=>null,"Married" => "Married","Single"=>"Single"]])
            //->add('dob')
      
            
            ->add('kebele')
          //  ->add('photo')
       
            ->add('woreda', EntityType::class, [
                'class' =>Woreda::class,
                'required'=>true,
                'attr'=>[
                    'class'=>'form-control  select2'
                    ],
                'query_builder' => function (EntityRepository $err) {
                    $result = $err->createQueryBuilder('e')
                 
                           ->orderBy('e.name', 'ASC');   
    
                     
                    return $result;
                },
            
                'placeholder' => "Select woreda",
            ])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
