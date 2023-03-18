<?php

namespace App\Controller;

use App\Entity\EmployeeCategory;
use App\Form\EmployeeCategoryType;
use App\Repository\EmployeeCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employee/category')]
class EmployeeCategoryController extends AbstractController
{
    #[Route('/', name: 'app_employee_category_index', methods: ['GET'])]
    public function index(EmployeeCategoryRepository $employeeCategoryRepository): Response
    {
        return $this->render('employee_category/index.html.twig', [
            'employee_categories' => $employeeCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_employee_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmployeeCategoryRepository $employeeCategoryRepository): Response
    {
        $employeeCategory = new EmployeeCategory();
        $form = $this->createForm(EmployeeCategoryType::class, $employeeCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeCategoryRepository->save($employeeCategory, true);

            return $this->redirectToRoute('app_employee_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee_category/new.html.twig', [
            'employee_category' => $employeeCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_category_show', methods: ['GET'])]
    public function show(EmployeeCategory $employeeCategory): Response
    {
        return $this->render('employee_category/show.html.twig', [
            'employee_category' => $employeeCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_employee_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EmployeeCategory $employeeCategory, EmployeeCategoryRepository $employeeCategoryRepository): Response
    {
        $form = $this->createForm(EmployeeCategoryType::class, $employeeCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeCategoryRepository->save($employeeCategory, true);

            return $this->redirectToRoute('app_employee_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee_category/edit.html.twig', [
            'employee_category' => $employeeCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_category_delete', methods: ['POST'])]
    public function delete(Request $request, EmployeeCategory $employeeCategory, EmployeeCategoryRepository $employeeCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employeeCategory->getId(), $request->request->get('_token'))) {
            $employeeCategoryRepository->remove($employeeCategory, true);
        }

        return $this->redirectToRoute('app_employee_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
