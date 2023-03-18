<?php

namespace App\Controller;

use App\Entity\EmploymentStatus;
use App\Form\EmploymentStatusType;
use App\Repository\EmploymentStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employment/status')]
class EmploymentStatusController extends AbstractController
{
    #[Route('/', name: 'app_employment_status_index', methods: ['GET'])]
    public function index(EmploymentStatusRepository $employmentStatusRepository): Response
    {
        return $this->render('employment_status/index.html.twig', [
            'employment_statuses' => $employmentStatusRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_employment_status_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmploymentStatusRepository $employmentStatusRepository): Response
    {
        $employmentStatus = new EmploymentStatus();
        $form = $this->createForm(EmploymentStatusType::class, $employmentStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employmentStatusRepository->save($employmentStatus, true);

            return $this->redirectToRoute('app_employment_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employment_status/new.html.twig', [
            'employment_status' => $employmentStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employment_status_show', methods: ['GET'])]
    public function show(EmploymentStatus $employmentStatus): Response
    {
        return $this->render('employment_status/show.html.twig', [
            'employment_status' => $employmentStatus,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_employment_status_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EmploymentStatus $employmentStatus, EmploymentStatusRepository $employmentStatusRepository): Response
    {
        $form = $this->createForm(EmploymentStatusType::class, $employmentStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employmentStatusRepository->save($employmentStatus, true);

            return $this->redirectToRoute('app_employment_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employment_status/edit.html.twig', [
            'employment_status' => $employmentStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employment_status_delete', methods: ['POST'])]
    public function delete(Request $request, EmploymentStatus $employmentStatus, EmploymentStatusRepository $employmentStatusRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employmentStatus->getId(), $request->request->get('_token'))) {
            $employmentStatusRepository->remove($employmentStatus, true);
        }

        return $this->redirectToRoute('app_employment_status_index', [], Response::HTTP_SEE_OTHER);
    }
}
