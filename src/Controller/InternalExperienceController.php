<?php

namespace App\Controller;

use App\Entity\InternalExperience;
use App\Form\InternalExperienceType;
use App\Repository\InternalExperienceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Andegna\DateTimeFactory;
use Andegna\DateTime as et_date;
use App\Repository\EmployeeRepository;
use App\Repository\JobTitleRepository;
use App\Repository\UnitRepository;

#[Route('/internal/experience')]
class InternalExperienceController extends AbstractController
{
    #[Route('/', name: 'app_internal_experience_index', methods: ['GET'])]
    public function index(InternalExperienceRepository $internalExperienceRepository): Response
    {
        return $this->render('internal_experience/index.html.twig', [
            'internal_experiences' => $internalExperienceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_internal_experience_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InternalExperienceRepository $internalExperienceRepository): Response
    {
        $internalExperience = new InternalExperience();
        $form = $this->createForm(InternalExperienceType::class, $internalExperience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $internalExperienceRepository->save($internalExperience, true);

            return $this->redirectToRoute('app_internal_experience_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('internal_experience/new.html.twig', [
            'internal_experience' => $internalExperience,
            'form' => $form,
        ]);
    }


    #[Route('/add_internal_experience', name: 'add_internal_experience', methods: ['POST'])]
    public function addExpereince( Request $request, JobTitleRepository $jobTitleRepository, EntityManagerInterface $entityManager, UnitRepository $unitRepository,  EmployeeRepository  $employeeRepository): Response
    {
         
          $internalExperience = new InternalExperience();

        if ($request->getMethod() == 'POST') {
            $employee_id   = $request->get('employee');
            $unit_id  = $request->get('unit');
            $job_id = $request->get('position');
            $from        = $request->get('from');
            $to          = $request->get('to');
            $employee = $employeeRepository->find($employee_id); // convert string ID to object
            $position = $jobTitleRepository->find($job_id); // convert string ID to object
            $education = $unitRepository->find($unit_id ); // convert string ID to object
            $frm   = explode('/', $from);
            $startDate  = DateTimeFactory::of($frm[2], $frm[1], $frm[0]);
            $end   = explode('/', $to);
            $endDate = DateTimeFactory::of($end[2], $end[1], $end[0]);
        
            if ($endDate->toGregorian() <=   $startDate->toGregorian()) {
            $this->addFlash('danger', 'Invalid date selections!');
       
            return $this->redirectToRoute('app_employee_show', ['id' => $employee->getId()]);
        
            }
            $internalExperience->setStartDate($startDate ->toGregorian());
            $internalExperience->setEndDate($endDate->toGregorian());
            $internalExperience->setUnit($education);
            $internalExperience->setJobTitle($position);
            $internalExperience->setCreatedAt(new \DateTimeImmutable());
            $internalExperience->setUser($this->getUser());
            $internalExperience->setEmployee($employee);
            $entityManager->persist($internalExperience);
            $entityManager->flush();
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    // 'data' => $result
                ]);
            }

            $this->addFlash('success', "The Employee internal experience has been successfully added!");
            return $this->redirectToRoute('app_employee_show', ['id' =>$employee->getId()]);
       }
        return $this->redirectToRoute('app_employee_show', [
             
            // 'id' => $employee->getId(),
             'internalExperience' => $internalExperience 
           // 'form' => $form
        ]);

    }
    #[Route('/{id}', name: 'app_internal_experience_show', methods: ['GET'])]
    public function show(InternalExperience $internalExperience): Response
    {
        return $this->render('internal_experience/show.html.twig', [
            'internal_experience' => $internalExperience,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_internal_experience_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, InternalExperience $internalExperience, InternalExperienceRepository $internalExperienceRepository): Response
    {
        $form = $this->createForm(InternalExperienceType::class, $internalExperience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $internalExperienceRepository->save($internalExperience, true);

            return $this->redirectToRoute('app_employee_show', ['id' =>$internalExperience->getEmployee()->getId()]);
        }

        return $this->renderForm('internal_experience/edit.html.twig', [
            'internal_experience' => $internalExperience,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_internal_experience_delete', methods: ['POST'])]
    public function delete(Request $request, InternalExperience $internalExperience, InternalExperienceRepository $internalExperienceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$internalExperience->getId(), $request->request->get('_token'))) {
            $internalExperienceRepository->remove($internalExperience, true);
        }

        $this->addFlash('success', "Successfylly deleted!");

        return $this->redirectToRoute('app_employee_show', ['id' =>$internalExperience->getEmployee()->getId()]);
        
    }
}



