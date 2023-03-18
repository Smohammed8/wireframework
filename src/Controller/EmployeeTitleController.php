<?php

namespace App\Controller;

use App\Entity\EmployeeTitle;
use App\Form\EmployeeTitleType;
use App\Repository\EmployeeTitleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employee-title')]
class EmployeeTitleController extends AbstractController
{
    #[Route('/', name: 'app_employee_title_index', methods: ['GET'])]
    public function index(EmployeeTitleRepository $employeeTitleRepository): Response
    {
        return $this->render('employee_title/index.html.twig', [
            'employee_titles' => $employeeTitleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_employee_title_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmployeeTitleRepository $employeeTitleRepository): Response
    {
        $employeeTitle = new EmployeeTitle();
        $form = $this->createForm(EmployeeTitleType::class, $employeeTitle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeTitleRepository->save($employeeTitle, true);

            return $this->redirectToRoute('app_employee_title_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee_title/new.html.twig', [
            'employee_title' => $employeeTitle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_title_show', methods: ['GET'])]
    public function show(EmployeeTitle $employeeTitle): Response
    {
        return $this->render('employee_title/show.html.twig', [
            'employee_title' => $employeeTitle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_employee_title_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EmployeeTitle $employeeTitle, EmployeeTitleRepository $employeeTitleRepository): Response
    {
        $form = $this->createForm(EmployeeTitleType::class, $employeeTitle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeTitleRepository->save($employeeTitle, true);

            return $this->redirectToRoute('app_employee_title_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee_title/edit.html.twig', [
            'employee_title' => $employeeTitle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_title_delete', methods: ['POST'])]
    public function delete(Request $request, EmployeeTitle $employeeTitle, EmployeeTitleRepository $employeeTitleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employeeTitle->getId(), $request->request->get('_token'))) {
            $employeeTitleRepository->remove($employeeTitle, true);
        }

        return $this->redirectToRoute('app_employee_title_index', [], Response::HTTP_SEE_OTHER);
    }
}
