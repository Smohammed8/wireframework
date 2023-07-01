<?php

namespace App\Controller;

use App\Entity\AcademicSession;
use App\Form\AcademicSessionType;
use App\Repository\AcademicSessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/academic/session')]
class AcademicSessionController extends AbstractController
{
    #[Route('/', name: 'app_academic_session_index', methods: ['GET'])]
    public function index(AcademicSessionRepository $academicSessionRepository): Response
    {
        return $this->render('academic_session/index.html.twig', [
            'academic_sessions' => $academicSessionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_academic_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AcademicSessionRepository $academicSessionRepository): Response
    {
        $academicSession = new AcademicSession();
        $form = $this->createForm(AcademicSessionType::class, $academicSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $academicSessionRepository->save($academicSession, true);

            return $this->redirectToRoute('app_academic_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('academic_session/new.html.twig', [
            'academic_session' => $academicSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_academic_session_show', methods: ['GET'])]
    public function show(AcademicSession $academicSession): Response
    {
        return $this->render('academic_session/show.html.twig', [
            'academic_session' => $academicSession,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_academic_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AcademicSession $academicSession, AcademicSessionRepository $academicSessionRepository): Response
    {
        $form = $this->createForm(AcademicSessionType::class, $academicSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $academicSessionRepository->save($academicSession, true);

            return $this->redirectToRoute('app_academic_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('academic_session/edit.html.twig', [
            'academic_session' => $academicSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_academic_session_delete', methods: ['POST'])]
    public function delete(Request $request, AcademicSession $academicSession, AcademicSessionRepository $academicSessionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$academicSession->getId(), $request->request->get('_token'))) {
            $academicSessionRepository->remove($academicSession, true);
        }

        return $this->redirectToRoute('app_academic_session_index', [], Response::HTTP_SEE_OTHER);
    }
}
