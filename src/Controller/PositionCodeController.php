<?php

namespace App\Controller;

use App\Entity\PositionCode;
use App\Form\PositionCodeType;
use App\Repository\PositionCodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/position/code')]
class PositionCodeController extends AbstractController
{
    #[Route('/', name: 'app_position_code_index', methods: ['GET'])]
    public function index(PositionCodeRepository $positionCodeRepository): Response
    {
        return $this->render('position_code/index.html.twig', [
            'position_codes' => $positionCodeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_position_code_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PositionCodeRepository $positionCodeRepository): Response
    {
        $positionCode = new PositionCode();
        $form = $this->createForm(PositionCodeType::class, $positionCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $positionCodeRepository->save($positionCode, true);

            return $this->redirectToRoute('app_position_code_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('position_code/new.html.twig', [
            'position_code' => $positionCode,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_position_code_show', methods: ['GET'])]
    public function show(PositionCode $positionCode): Response
    {
        return $this->render('position_code/show.html.twig', [
            'position_code' => $positionCode,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_position_code_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PositionCode $positionCode, PositionCodeRepository $positionCodeRepository): Response
    {
        $form = $this->createForm(PositionCodeType::class, $positionCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $positionCodeRepository->save($positionCode, true);

            return $this->redirectToRoute('app_position_code_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('position_code/edit.html.twig', [
            'position_code' => $positionCode,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_position_code_delete', methods: ['POST'])]
    public function delete(Request $request, PositionCode $positionCode, PositionCodeRepository $positionCodeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$positionCode->getId(), $request->request->get('_token'))) {
            $positionCodeRepository->remove($positionCode, true);
        }

        return $this->redirectToRoute('app_position_code_index', [], Response::HTTP_SEE_OTHER);
    }
}
