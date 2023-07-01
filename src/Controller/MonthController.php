<?php

namespace App\Controller;

use App\Entity\Month;
use App\Form\MonthType;
use App\Repository\MonthRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/month')]
class MonthController extends AbstractController
{
    #[Route('/', name: 'app_month_index', methods: ['GET'])]
    public function index(MonthRepository $monthRepository): Response
    {
        return $this->render('month/index.html.twig', [
            'months' => $monthRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_month_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MonthRepository $monthRepository): Response
    {
        $month = new Month();
        $form = $this->createForm(MonthType::class, $month);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $monthRepository->save($month, true);

            return $this->redirectToRoute('app_month_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('month/new.html.twig', [
            'month' => $month,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_month_show', methods: ['GET'])]
    public function show(Month $month): Response
    {
        return $this->render('month/show.html.twig', [
            'month' => $month,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_month_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Month $month, MonthRepository $monthRepository): Response
    {
        $form = $this->createForm(MonthType::class, $month);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $monthRepository->save($month, true);

            return $this->redirectToRoute('app_month_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('month/edit.html.twig', [
            'month' => $month,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_month_delete', methods: ['POST'])]
    public function delete(Request $request, Month $month, MonthRepository $monthRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$month->getId(), $request->request->get('_token'))) {
            $monthRepository->remove($month, true);
        }

        return $this->redirectToRoute('app_month_index', [], Response::HTTP_SEE_OTHER);
    }
}
