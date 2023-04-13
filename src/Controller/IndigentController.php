<?php

namespace App\Controller;

use App\Entity\Indigent;
use App\Form\IndigentType;
use App\Repository\IndigentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/indigent')]
class IndigentController extends AbstractController
{
    #[Route('/', name: 'app_indigent_index', methods: ['GET'])]
    public function index(IndigentRepository $indigentRepository): Response
    {
        return $this->render('indigent/index.html.twig', [
            'indigents' => $indigentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_indigent_new', methods: ['GET', 'POST'])]
    public function new(Request $request, IndigentRepository $indigentRepository): Response
    {
        $indigent = new Indigent();
        $form = $this->createForm(IndigentType::class, $indigent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $indigentRepository->save($indigent, true);

            return $this->redirectToRoute('app_indigent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('indigent/new.html.twig', [
            'indigent' => $indigent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_indigent_show', methods: ['GET'])]
    public function show(Indigent $indigent): Response
    {
        return $this->render('indigent/show.html.twig', [
            'indigent' => $indigent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_indigent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Indigent $indigent, IndigentRepository $indigentRepository): Response
    {
        $form = $this->createForm(IndigentType::class, $indigent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $indigentRepository->save($indigent, true);

            return $this->redirectToRoute('app_indigent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('indigent/edit.html.twig', [
            'indigent' => $indigent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_indigent_delete', methods: ['POST'])]
    public function delete(Request $request, Indigent $indigent, IndigentRepository $indigentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$indigent->getId(), $request->request->get('_token'))) {
            $indigentRepository->remove($indigent, true);
        }

        return $this->redirectToRoute('app_indigent_index', [], Response::HTTP_SEE_OTHER);
    }
}
