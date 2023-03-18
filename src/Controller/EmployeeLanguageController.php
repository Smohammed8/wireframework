<?php

namespace App\Controller;

use App\Entity\EmployeeLanguage;
use App\Form\EmployeeLanguageType;
use App\Repository\EmployeeLanguageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employee/language')]
class EmployeeLanguageController extends AbstractController
{
    #[Route('/', name: 'app_employee_language_index', methods: ['GET'])]
    public function index(EmployeeLanguageRepository $employeeLanguageRepository): Response
    {
        return $this->render('employee_language/index.html.twig', [
            'employee_languages' => $employeeLanguageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_employee_language_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmployeeLanguageRepository $employeeLanguageRepository): Response
    {
        $employeeLanguage = new EmployeeLanguage();
        $form = $this->createForm(EmployeeLanguageType::class, $employeeLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeLanguageRepository->save($employeeLanguage, true);

            return $this->redirectToRoute('app_employee_language_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee_language/new.html.twig', [
            'employee_language' => $employeeLanguage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_language_show', methods: ['GET'])]
    public function show(EmployeeLanguage $employeeLanguage): Response
    {
        return $this->render('employee_language/show.html.twig', [
            'employee_language' => $employeeLanguage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_employee_language_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EmployeeLanguage $employeeLanguage, EmployeeLanguageRepository $employeeLanguageRepository): Response
    {
        $form = $this->createForm(EmployeeLanguageType::class, $employeeLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeLanguageRepository->save($employeeLanguage, true);

            return $this->redirectToRoute('app_employee_language_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee_language/edit.html.twig', [
            'employee_language' => $employeeLanguage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_language_delete', methods: ['POST'])]
    public function delete(Request $request, EmployeeLanguage $employeeLanguage, EmployeeLanguageRepository $employeeLanguageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employeeLanguage->getId(), $request->request->get('_token'))) {
            $employeeLanguageRepository->remove($employeeLanguage, true);
        }

        return $this->redirectToRoute('app_employee_language_index', [], Response::HTTP_SEE_OTHER);
    }
}
