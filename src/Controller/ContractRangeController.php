<?php

namespace App\Controller;

use App\Entity\ContractRange;
use App\Form\ContractRangeType;
use App\Repository\ContractRangeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contract/range')]
class ContractRangeController extends AbstractController
{
    #[Route('/', name: 'app_contract_range_index', methods: ['GET'])]
    public function index(ContractRangeRepository $contractRangeRepository): Response
    {
        return $this->render('contract_range/index.html.twig', [
            'contract_ranges' => $contractRangeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contract_range_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContractRangeRepository $contractRangeRepository): Response
    {
        $contractRange = new ContractRange();
        $form = $this->createForm(ContractRangeType::class, $contractRange);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contractRangeRepository->save($contractRange, true);

            return $this->redirectToRoute('app_contract_range_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contract_range/new.html.twig', [
            'contract_range' => $contractRange,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contract_range_show', methods: ['GET'])]
    public function show(ContractRange $contractRange): Response
    {
        return $this->render('contract_range/show.html.twig', [
            'contract_range' => $contractRange,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contract_range_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ContractRange $contractRange, ContractRangeRepository $contractRangeRepository): Response
    {
        $form = $this->createForm(ContractRangeType::class, $contractRange);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contractRangeRepository->save($contractRange, true);

            return $this->redirectToRoute('app_contract_range_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contract_range/edit.html.twig', [
            'contract_range' => $contractRange,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contract_range_delete', methods: ['POST'])]
    public function delete(Request $request, ContractRange $contractRange, ContractRangeRepository $contractRangeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contractRange->getId(), $request->request->get('_token'))) {
            $contractRangeRepository->remove($contractRange, true);
        }

        return $this->redirectToRoute('app_contract_range_index', [], Response::HTTP_SEE_OTHER);
    }
}
