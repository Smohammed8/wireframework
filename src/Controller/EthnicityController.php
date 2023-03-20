<?php

namespace App\Controller;

use App\Entity\Ethnicity;
use App\Form\EthnicityType;
use App\Repository\EthnicityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ethnicity')]
class EthnicityController extends AbstractController
{
    #[Route('/', name: 'app_ethnicity_index', methods: ['GET'])]
    public function index(EthnicityRepository $ethnicityRepository): Response
    {
        return $this->render('ethnicity/index.html.twig', [
            'ethnicities' => $ethnicityRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ethnicity_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EthnicityRepository $ethnicityRepository): Response
    {
        $ethnicity = new Ethnicity();
        $form = $this->createForm(EthnicityType::class, $ethnicity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ethnicityRepository->save($ethnicity, true);

            return $this->redirectToRoute('app_ethnicity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ethnicity/new.html.twig', [
            'ethnicity' => $ethnicity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ethnicity_show', methods: ['GET'])]
    public function show(Ethnicity $ethnicity): Response
    {
        return $this->render('ethnicity/show.html.twig', [
            'ethnicity' => $ethnicity,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ethnicity_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ethnicity $ethnicity, EthnicityRepository $ethnicityRepository): Response
    {
        $form = $this->createForm(EthnicityType::class, $ethnicity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ethnicityRepository->save($ethnicity, true);

            return $this->redirectToRoute('app_ethnicity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ethnicity/edit.html.twig', [
            'ethnicity' => $ethnicity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ethnicity_delete', methods: ['POST'])]
    public function delete(Request $request, Ethnicity $ethnicity, EthnicityRepository $ethnicityRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ethnicity->getId(), $request->request->get('_token'))) {
            $ethnicityRepository->remove($ethnicity, true);
        }

        return $this->redirectToRoute('app_ethnicity_index', [], Response::HTTP_SEE_OTHER);
    }
}
