<?php

namespace App\Controller;

use App\Entity\EmployeeFamily;
use App\Form\EmployeeFamilyType;
use App\Repository\EmployeeFamilyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employee/family')]
class EmployeeFamilyController extends AbstractController
{
    #[Route('/', name: 'app_employee_family_index', methods: ['GET'])]
    public function index(EmployeeFamilyRepository $employeeFamilyRepository): Response
    {
        return $this->render('employee_family/index.html.twig', [
            'employee_families' => $employeeFamilyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_employee_family_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmployeeFamilyRepository $employeeFamilyRepository): Response
    {
        $employeeFamily = new EmployeeFamily();
        $form = $this->createForm(EmployeeFamilyType::class, $employeeFamily);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeFamilyRepository->save($employeeFamily, true);

            return $this->redirectToRoute('app_employee_family_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee_family/new.html.twig', [
            'employee_family' => $employeeFamily,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_family_show', methods: ['GET'])]
    public function show(EmployeeFamily $employeeFamily): Response
    {
        return $this->render('employee_family/show.html.twig', [
            'employee_family' => $employeeFamily,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_employee_family_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EmployeeFamily $employeeFamily, EmployeeFamilyRepository $employeeFamilyRepository): Response
    {
        $form = $this->createForm(EmployeeFamilyType::class, $employeeFamily);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeFamilyRepository->save($employeeFamily, true);

            return $this->redirectToRoute('app_employee_family_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee_family/edit.html.twig', [
            'employee_family' => $employeeFamily,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_family_delete', methods: ['POST'])]
    public function delete(Request $request, EmployeeFamily $employeeFamily, EmployeeFamilyRepository $employeeFamilyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employeeFamily->getId(), $request->request->get('_token'))) {
            $employeeFamilyRepository->remove($employeeFamily, true);
        }

        return $this->redirectToRoute('app_employee_family_index', [], Response::HTTP_SEE_OTHER);
    }
}
