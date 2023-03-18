<?php

namespace App\Controller;

use App\Entity\EmploymentType;
use App\Form\EmploymentTypeType;
use App\Repository\EmploymentTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employment/type')]
class EmploymentTypeController extends AbstractController
{
    #[Route('/', name: 'app_employment_type_index', methods: ['GET'])]
    public function index(EmploymentTypeRepository $employmentTypeRepository): Response
    {
        return $this->render('employment_type/index.html.twig', [
            'employment_types' => $employmentTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_employment_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmploymentTypeRepository $employmentTypeRepository): Response
    {
        $employmentType = new EmploymentType();
        $form = $this->createForm(EmploymentTypeType::class, $employmentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employmentTypeRepository->save($employmentType, true);

            return $this->redirectToRoute('app_employment_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employment_type/new.html.twig', [
            'employment_type' => $employmentType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employment_type_show', methods: ['GET'])]
    public function show(EmploymentType $employmentType): Response
    {
        return $this->render('employment_type/show.html.twig', [
            'employment_type' => $employmentType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_employment_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EmploymentType $employmentType, EmploymentTypeRepository $employmentTypeRepository): Response
    {
        $form = $this->createForm(EmploymentTypeType::class, $employmentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employmentTypeRepository->save($employmentType, true);

            return $this->redirectToRoute('app_employment_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employment_type/edit.html.twig', [
            'employment_type' => $employmentType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employment_type_delete', methods: ['POST'])]
    public function delete(Request $request, EmploymentType $employmentType, EmploymentTypeRepository $employmentTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employmentType->getId(), $request->request->get('_token'))) {
            $employmentTypeRepository->remove($employmentType, true);
        }

        return $this->redirectToRoute('app_employment_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
