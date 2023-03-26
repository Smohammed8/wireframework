<?php

namespace App\Controller;

use App\Entity\EmployeeEducation;
use App\Entity\Employee;
use App\Form\EmployeeEducationType;
use App\Repository\EmployeeEducationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Andegna\DateTimeFactory;
use Andegna\DateTime as et_date;
use App\Repository\EducationalLevelRepository;
use App\Repository\EmployeeRepository;

#[Route('/employee/education')]
class EmployeeEducationController extends AbstractController
{
    #[Route('/', name: 'app_employee_education_index', methods: ['GET'])]
    public function index(EmployeeEducationRepository $employeeEducationRepository): Response
    {
        return $this->render('employee_education/index.html.twig', [
            'employee_educations' => $employeeEducationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_employee_education_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmployeeEducationRepository $employeeEducationRepository): Response
    {
        $employeeEducation = new EmployeeEducation();
        $form = $this->createForm(EmployeeEducationType::class, $employeeEducation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeEducationRepository->save($employeeEducation, true);

            return $this->redirectToRoute('app_employee_education_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee_education/new.html.twig', [
            'employee_education' => $employeeEducation,
            'form' => $form,
        ]);
    }



    #[Route('/add_education', name: 'add_education', methods: ['POST'])]
    public function addEducation( Request $request, EntityManagerInterface $entityManager, EducationalLevelRepository $educationalLevelRepository,  EmployeeRepository $employeeRepository): Response
    {
       
          $employeeEducation = new EmployeeEducation();
        if ($request->getMethod() == 'POST') {
            $employee_id   = $request->get('employee');
   
            $education_id  = $request->get('education');
            $institution = $request->get('institution');
            $from        = $request->get('from');
            $to          = $request->get('to');
            $file        = $request->get('file');

            $employee = $employeeRepository->find($employee_id); // convert string ID to object
            $education = $educationalLevelRepository->find($education_id ); // convert string ID to object
          ///  dd( $employee );
            $frm   = explode('/', $from);
            $startDate  = DateTimeFactory::of($frm[2], $frm[1], $frm[0]);

            $end   = explode('/', $to);
            $endDate = DateTimeFactory::of($end[2], $end[1], $end[0]);
        
            if ($endDate->toGregorian() <=   $startDate->toGregorian()) {
            $this->addFlash('danger', 'Invalid date selections!');
       
            return $this->redirectToRoute('app_employee_show', ['id' => $employee->getId()]);
        
            }
            if($file   != null){
            $destination = $this->getParameter('kernel.project_dir') . '/public/employee_file';
           // $newFilename = $employee->getId() . uniqid() . '.' . $uploadedFile->getClientOriginalName();
             $newFilename = $employeeEducation->getId() . uniqid() . '.' . $file->getClientOriginalExtension();
             $file->move($destination, $newFilename);
             $employeeEducation->setfile($newFilename);
            } 
            else{
                $employeeEducation->setfile(null);  
            }
              
            $employeeEducation->setStartDate($startDate ->toGregorian());
            $employeeEducation->setEndDate($endDate->toGregorian());
            $employeeEducation->setEducationLevel($education);
            $employeeEducation->setInstitution($institution);
            $employeeEducation->setCreatedAt(new \DateTimeImmutable());
            $employeeEducation->setUser($this->getUser());
            $employeeEducation->setEmployee($employee);
            $entityManager->persist($employeeEducation);
            $entityManager->flush();
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    // 'data' => $result
                ]);
            }

            $this->addFlash('success', "The Employee education information has been successfully registered!");
            return $this->redirectToRoute('app_employee_show', ['id' =>$employee->getId()]);
       }
        return $this->redirectToRoute('app_employee_show', [
             
            // 'id' => $employee->getId(),
             'employeeEducation' => $employeeEducation 
           // 'form' => $form
        ]);

    }


    #[Route('/{id}', name: 'app_employee_education_show', methods: ['GET'])]
    public function show(EmployeeEducation $employeeEducation): Response
    {
        return $this->render('employee_education/show.html.twig', [
            'employee_education' => $employeeEducation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_employee_education_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EmployeeEducation $employeeEducation, EmployeeEducationRepository $employeeEducationRepository): Response
    {
        $form = $this->createForm(EmployeeEducationType::class, $employeeEducation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeEducationRepository->save($employeeEducation, true);

            return $this->redirectToRoute('app_employee_education_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee_education/edit.html.twig', [
            'employee_education' => $employeeEducation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_education_delete', methods: ['POST'])]
    public function delete(Request $request, EmployeeEducation $employeeEducation, EmployeeEducationRepository $employeeEducationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employeeEducation->getId(), $request->request->get('_token'))) {
            $employeeEducationRepository->remove($employeeEducation, true);
        }

        //return $this->redirectToRoute('app_employee_education_index', [], Response::HTTP_SEE_OTHER);

        $this->addFlash('success', "Successfylly deleted!");

        return $this->redirectToRoute('app_employee_show', ['id' =>$employeeEducation->getEmployee()->getId()]);
    }
}
