<?php

namespace App\Controller;

use App\Entity\ExternalExperience;
use App\Form\ExternalExperienceType;
use App\Repository\ExternalExperienceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/external/experience')]
class ExternalExperienceController extends AbstractController
{
    #[Route('/', name: 'app_external_experience_index', methods: ['GET'])]
    public function index(ExternalExperienceRepository $externalExperienceRepository): Response
    {
        return $this->render('external_experience/index.html.twig', [
            'external_experiences' => $externalExperienceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_external_experience_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ExternalExperienceRepository $externalExperienceRepository): Response
    {
        $externalExperience = new ExternalExperience();
        $form = $this->createForm(ExternalExperienceType::class, $externalExperience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $externalExperienceRepository->save($externalExperience, true);

            return $this->redirectToRoute('app_external_experience_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('external_experience/new.html.twig', [
            'external_experience' => $externalExperience,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_external_experience_show', methods: ['GET'])]
    public function show(ExternalExperience $externalExperience): Response
    {
        return $this->render('external_experience/show.html.twig', [
            'external_experience' => $externalExperience,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_external_experience_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ExternalExperience $externalExperience, ExternalExperienceRepository $externalExperienceRepository): Response
    {
        $form = $this->createForm(ExternalExperienceType::class, $externalExperience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $externalExperienceRepository->save($externalExperience, true);

            return $this->redirectToRoute('app_external_experience_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('external_experience/edit.html.twig', [
            'external_experience' => $externalExperience,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_external_experience_delete', methods: ['POST'])]
    public function delete(Request $request, ExternalExperience $externalExperience, ExternalExperienceRepository $externalExperienceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$externalExperience->getId(), $request->request->get('_token'))) {
            $externalExperienceRepository->remove($externalExperience, true);
        }

        return $this->redirectToRoute('app_external_experience_index', [], Response::HTTP_SEE_OTHER);
    }
}
