<?php

namespace App\Controller;

use App\Entity\MaritalStatus;
use App\Form\MaritalStatusType;
use App\Repository\MaritalStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/marital/status')]
class MaritalStatusController extends AbstractController
{
    #[Route('/', name: 'app_marital_status_index', methods: ['GET'])]
    public function index(MaritalStatusRepository $maritalStatusRepository): Response
    {
        return $this->render('marital_status/index.html.twig', [
            'marital_statuses' => $maritalStatusRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_marital_status_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MaritalStatusRepository $maritalStatusRepository): Response
    {
        $maritalStatus = new MaritalStatus();
        $form = $this->createForm(MaritalStatusType::class, $maritalStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $maritalStatusRepository->save($maritalStatus, true);

            return $this->redirectToRoute('app_marital_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('marital_status/new.html.twig', [
            'marital_status' => $maritalStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_marital_status_show', methods: ['GET'])]
    public function show(MaritalStatus $maritalStatus): Response
    {
        return $this->render('marital_status/show.html.twig', [
            'marital_status' => $maritalStatus,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_marital_status_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MaritalStatus $maritalStatus, MaritalStatusRepository $maritalStatusRepository): Response
    {
        $form = $this->createForm(MaritalStatusType::class, $maritalStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $maritalStatusRepository->save($maritalStatus, true);

            return $this->redirectToRoute('app_marital_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('marital_status/edit.html.twig', [
            'marital_status' => $maritalStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_marital_status_delete', methods: ['POST'])]
    public function delete(Request $request, MaritalStatus $maritalStatus, MaritalStatusRepository $maritalStatusRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$maritalStatus->getId(), $request->request->get('_token'))) {
            $maritalStatusRepository->remove($maritalStatus, true);
        }

        return $this->redirectToRoute('app_marital_status_index', [], Response::HTTP_SEE_OTHER);
    }
}
