<?php

namespace App\Controller;

use App\Entity\Religion;
use App\Form\ReligionType;
use App\Repository\ReligionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/religion')]
class ReligionController extends AbstractController
{
    #[Route('/', name: 'app_religion_index', methods: ['GET'])]
    public function index(ReligionRepository $religionRepository): Response
    {
        return $this->render('religion/index.html.twig', [
            'religions' => $religionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_religion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReligionRepository $religionRepository): Response
    {
        $religion = new Religion();
        $form = $this->createForm(ReligionType::class, $religion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $religionRepository->save($religion, true);

            return $this->redirectToRoute('app_religion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('religion/new.html.twig', [
            'religion' => $religion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_religion_show', methods: ['GET'])]
    public function show(Religion $religion): Response
    {
        return $this->render('religion/show.html.twig', [
            'religion' => $religion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_religion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Religion $religion, ReligionRepository $religionRepository): Response
    {
        $form = $this->createForm(ReligionType::class, $religion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $religionRepository->save($religion, true);

            return $this->redirectToRoute('app_religion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('religion/edit.html.twig', [
            'religion' => $religion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_religion_delete', methods: ['POST'])]
    public function delete(Request $request, Religion $religion, ReligionRepository $religionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$religion->getId(), $request->request->get('_token'))) {
            $religionRepository->remove($religion, true);
        }

        return $this->redirectToRoute('app_religion_index', [], Response::HTTP_SEE_OTHER);
    }
}
