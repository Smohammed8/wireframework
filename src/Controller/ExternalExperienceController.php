<?php

namespace App\Controller;

use App\Entity\ExternalExperience;
use App\Form\ExternalExperienceType;
use App\Repository\EmployeeRepository;
use App\Repository\ExternalExperienceRepository;
use App\Repository\JobTitleRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Andegna\DateTimeFactory;
use Andegna\DateTime as et_date;

#[Route('/external/experience')]
class ExternalExperienceController extends AbstractController
{
    #[Route('/', name: 'app_external_experience_index', methods: ['GET'])]
    public function index(ExternalExperienceRepository $externalExperienceRepository): Response
    {
        return $this->render('external_experience/index.html.twig', [
            'external_experiences' => $externalExperienceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_external_experience_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ExternalExperienceRepository $externalExperienceRepository): Response
    {
        $externalExperience = new ExternalExperience();
        $form = $this->createForm(ExternalExperienceType::class, $externalExperience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $externalExperienceRepository->save($externalExperience, true);

            return $this->redirectToRoute('app_external_experience_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('external_experience/new.html.twig', [
            'external_experience' => $externalExperience,
            'form' => $form,
        ]);
    }


    #[Route('/add_external_experience', name: 'add_external_experience', methods: ['POST'])]
    public function externalExperience( Request $request, JobTitleRepository  $jobTitleRepository, EntityManagerInterface $entityManager, EmployeeRepository   $employeeRepository): Response
    {
         
          $externalExperience = new ExternalExperience();
        if ($request->getMethod() == 'POST') {
            $employee_id   = $request->get('employee');
            $campany  = $request->get('campany');
            $position = $request->get('position');
            $clearance = $request->get('clearance');
            $from        = $request->get('from');
            $to          = $request->get('to');
            $frm   = explode('/', $from);
            $startDate  = DateTimeFactory::of($frm[2], $frm[1], $frm[0]);
            $end   = explode('/', $to);
            $endDate = DateTimeFactory::of($end[2], $end[1], $end[0]);
            $employee = $employeeRepository->find($employee_id); // convert string ID to object
            if ($endDate->toGregorian() <=   $startDate->toGregorian()) {
            $this->addFlash('danger', 'Invalid date selections!');
       
            return $this->redirectToRoute('app_employee_show', ['id' => $employee->getId()]);
        
            }
            $externalExperience->setStartDate($startDate ->toGregorian());
            $externalExperience->setEndDate($endDate->toGregorian());
            $externalExperience->setCompanyName($campany);
            $externalExperience->setJobTitle($position);
            $externalExperience->setClearance($clearance);
            $externalExperience->setEmployee($employee);
            $entityManager->persist($externalExperience);
            $entityManager->flush();
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    // 'data' => $result
                ]);
            }

            $this->addFlash('success', "The Employee external experience has been successfully added!");
            return $this->redirectToRoute('app_employee_show', ['id' =>$employee->getId()]);
       }
        return $this->redirectToRoute('app_employee_show', [
             
            // 'id' => $employee->getId(),
             'externalExperience' => $externalExperience 
           // 'form' => $form
        ]);

    }

    

    #[Route('/{id}', name: 'app_external_experience_show', methods: ['GET'])]
    public function show(ExternalExperience $externalExperience): Response
    {
        return $this->render('external_experience/show.html.twig', [
            'external_experience' => $externalExperience,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_external_experience_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ExternalExperience $externalExperience, ExternalExperienceRepository $externalExperienceRepository): Response
    {
        $form = $this->createForm(ExternalExperienceType::class, $externalExperience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $externalExperienceRepository->save($externalExperience, true);

            return $this->redirectToRoute('app_external_experience_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('external_experience/edit.html.twig', [
            'external_experience' => $externalExperience,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_external_experience_delete', methods: ['POST'])]
    public function delete(Request $request, ExternalExperience $externalExperience, ExternalExperienceRepository $externalExperienceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$externalExperience->getId(), $request->request->get('_token'))) {
            $externalExperienceRepository->remove($externalExperience, true);
        }
         $this->addFlash('success', "Successfylly deleted!");
         return $this->redirectToRoute('app_employee_show', ['id' =>$externalExperience->getEmployee()->getId()]);

    }
}
