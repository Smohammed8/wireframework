<?php

namespace App\Controller;

use App\Entity\Agreement;
use App\Form\AgreementType;
use App\Repository\AgreementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/agreement')]
class AgreementController extends AbstractController
{
    #[Route('/', name: 'app_agreement_index', methods: ['GET'])]
    public function index(AgreementRepository $agreementRepository): Response
    {
        return $this->render('agreement/index.html.twig', [
            'agreements' => $agreementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_agreement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AgreementRepository $agreementRepository): Response
    {
        $agreement = new Agreement();
        $form = $this->createForm(AgreementType::class, $agreement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agreementRepository->save($agreement, true);

            return $this->redirectToRoute('app_agreement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('agreement/new.html.twig', [
            'agreement' => $agreement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agreement_show', methods: ['GET'])]
    public function show(Agreement $agreement): Response
    {
        return $this->render('agreement/show.html.twig', [
            'agreement' => $agreement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_agreement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Agreement $agreement, AgreementRepository $agreementRepository): Response
    {
        $form = $this->createForm(AgreementType::class, $agreement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agreementRepository->save($agreement, true);

            return $this->redirectToRoute('app_agreement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('agreement/edit.html.twig', [
            'agreement' => $agreement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agreement_delete', methods: ['POST'])]
    public function delete(Request $request, Agreement $agreement, AgreementRepository $agreementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agreement->getId(), $request->request->get('_token'))) {
            $agreementRepository->remove($agreement, true);
        }

        return $this->redirectToRoute('app_agreement_index', [], Response::HTTP_SEE_OTHER);
    }
}
