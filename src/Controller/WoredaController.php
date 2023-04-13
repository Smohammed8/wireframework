<?php

namespace App\Controller;

use App\Entity\Woreda;
use App\Form\WoredaType;
use App\Repository\WoredaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/woreda')]
class WoredaController extends AbstractController
{
    #[Route('/', name: 'app_woreda_index', methods: ['GET'])]
    public function index(WoredaRepository $woredaRepository): Response
    {
        return $this->render('woreda/index.html.twig', [
            'woredas' => $woredaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_woreda_new', methods: ['GET', 'POST'])]
    public function new(Request $request, WoredaRepository $woredaRepository): Response
    {
        $woreda = new Woreda();
        $form = $this->createForm(WoredaType::class, $woreda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $woredaRepository->save($woreda, true);

            return $this->redirectToRoute('app_woreda_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('woreda/new.html.twig', [
            'woreda' => $woreda,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_woreda_show', methods: ['GET'])]
    public function show(Woreda $woreda): Response
    {
        return $this->render('woreda/show.html.twig', [
            'woreda' => $woreda,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_woreda_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Woreda $woreda, WoredaRepository $woredaRepository): Response
    {
        $form = $this->createForm(WoredaType::class, $woreda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $woredaRepository->save($woreda, true);

            return $this->redirectToRoute('app_woreda_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('woreda/edit.html.twig', [
            'woreda' => $woreda,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_woreda_delete', methods: ['POST'])]
    public function delete(Request $request, Woreda $woreda, WoredaRepository $woredaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$woreda->getId(), $request->request->get('_token'))) {
            $woredaRepository->remove($woreda, true);
        }

        return $this->redirectToRoute('app_woreda_index', [], Response::HTTP_SEE_OTHER);
    }
}
