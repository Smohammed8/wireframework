<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Blo;
use App\Entity\Country;
use App\Entity\EducationalLevel;
use App\Entity\EmploymentType;
use App\Entity\EmployeeCategory;
use App\Entity\EmployeeTitle;
use App\Entity\Ethnicity;
use App\Entity\FieldOfStudy;
use App\Entity\MaritalStatus;
use App\Entity\Position;
use App\Entity\Religion;
use App\Entity\EmploymentStatus;

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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\File\File;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('fatherName')
            ->add('lastName')
       
            ->add('gender', ChoiceType::class,["choices" => ["Select sex"=>null,"Male" => "M","Female"=>"F"]])
          //  ->add('dateOfBirth')
          //  ->add('phone')
           // ->add('phone',TelType::class)

            ->add('birthPlace')
            // ->add('photo',FileType::class)
            ->add('photo', FileType::class, array('data_class' => null, 'required' => false))

            // ->add('photo', FileType::class, array(
            //     'attr' => array(
            //         'id' => 'customFile',
            //         'class' => 'sr-only',
            //         'accept' => 'image/jpeg,image/png,image/jpg'
            //     ),
            //     'label' => 'Employee Photo',


            // ))

       
        





            ->add('bloodGroup', ChoiceType::class,["choices" => ["Select blood group"=>null,"A" => "A","B"=>"B","AB"=>"AB","O"=>"O"]])
            ->add('eyeColor', ChoiceType::class,["choices" => ["Select eye color"=>null,"Amber" => "Amber","Blue"=>"Blue","Brown"=>"Brown","Gray"=>"Gray" ,"Green"=>"Green","Red"=>"Red","Hazel"=>"Hazel"]])
          //  ->add('email')
            ->add('email',EmailType::class,['mapped'=>false])
        //    ->add('idNumber')
            ->add('pentionNumber')
          //  ->add('createdAt')
            ->add('firstNameAm')
            ->add('fatherNameAm')
            ->add('lastNameAm')
        //    ->add('updatedAt')
            //->add('employementDate')
 
            ->add('employeeTitle', EntityType::class, [
                'class' =>EmployeeTitle::class,
                'required'=>false,
                'query_builder' => function (EntityRepository $err) {
                    $result = $err->createQueryBuilder('e')
                 
                           ->orderBy('e.name', 'ASC');   
    
                     
                    return $result;
                },
            
                'placeholder' => "Select employee title",
            ])




            ->add('educationallevel', EntityType::class, [
                'class' =>EducationalLevel::class,
                'required'=>false,
                'query_builder' => function (EntityRepository $err) {
                    $result = $err->createQueryBuilder('e')
                 
                           ->orderBy('e.name', 'ASC');   
    
                     
                    return $result;
                },
            
                'placeholder' => "Select educational level",
            ])




            ->add('martitalStatus', EntityType::class, [
                'class' =>MaritalStatus::class,
                'required'=>false,
                'query_builder' => function (EntityRepository $err) {
                    $result = $err->createQueryBuilder('e')
                 
                           ->orderBy('e.name', 'ASC');   
    
                     
                    return $result;
                },
            
                'placeholder' => "Select marital status",
            ])



            ->add('ethnicity', EntityType::class, [
                'class' =>Ethnicity::class,
                'required'=>false,
                'query_builder' => function (EntityRepository $err) {
                    $result = $err->createQueryBuilder('e')
                 
                           ->orderBy('e.name', 'ASC');   
    
                     
                    return $result;
                },
            
                'placeholder' => "Select ethinicity",
            ])


            ->add('religion', EntityType::class, [
                'class' =>Religion::class,
                'required'=>false,
                'query_builder' => function (EntityRepository $err) {
                    $result = $err->createQueryBuilder('e')
                 
                           ->orderBy('e.name', 'ASC');   
    
                     
                    return $result;
                },
            
                'placeholder' => "Select religion",
            ])


            ->add('fieldOfStudy', EntityType::class, [
                'class' =>FieldOfStudy::class,
                'required'=>false,
                'query_builder' => function (EntityRepository $err) {
                    $result = $err->createQueryBuilder('e')
                 
                           ->orderBy('e.name', 'ASC');   
    
                     
                    return $result;
                },
            
                'placeholder' => "Select field of study",
            ])

            ->add('employmentType', EntityType::class, [
                'class' =>EmploymentType::class,
                'required'=>false,
                'query_builder' => function (EntityRepository $err) {
                    $result = $err->createQueryBuilder('e')
                 
                           ->orderBy('e.name', 'ASC');   
    
                     
                    return $result;
                },
            
                'placeholder' => "Select employment type",
            ])

            ->add('employeeCurrentStatus', EntityType::class, [
                'class' =>EmploymentStatus::class,
                'required'=>false,
                'query_builder' => function (EntityRepository $err) {
                    $result = $err->createQueryBuilder('e')
                 
                           ->orderBy('e.name', 'ASC');   
    
                     
                    return $result;
                },
            
                'placeholder' => "Select Employee Current status",
            ])


            ->add('nationality', EntityType::class, [
                'class' =>Country::class,
                'required'=>false,
                'query_builder' => function (EntityRepository $err) {
                    $result = $err->createQueryBuilder('e')
                 
                           ->orderBy('e.name', 'ASC');   
    
                     
                    return $result;
                },
            
                'placeholder' => "Select nationality",
            ])


            ->add('employeeCategory', EntityType::class, [
                'class' =>EmployeeCategory::class,
                'required'=>false,
                'query_builder' => function (EntityRepository $err) {
                    $result = $err->createQueryBuilder('e')
                 
                           ->orderBy('e.name', 'ASC');   
    
                     
                    return $result;
                },
            
                'placeholder' => "Select employee category",
            ])



            ->add('position', EntityType::class, [
                'class' =>Position::class,
                'required'=>false,
                'query_builder' => function (EntityRepository $err) {
                    $result = $err->createQueryBuilder('e')
                 
                           ->orderBy('e.jobTitle', 'ASC');   
    
                     
                    return $result;
                },
            
                'placeholder' => "Select position",
            ])


        
       
            ->add('institution')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
