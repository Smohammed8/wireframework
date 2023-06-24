<?php

namespace App\Controller;

use App\Entity\StudentParent;
use App\Form\StudentParentType;
use App\Repository\StudentParentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student/parent')]
class StudentParentController extends AbstractController
{
    #[Route('/', name: 'app_student_parent_index', methods: ['GET'])]
    public function index(StudentParentRepository $studentParentRepository): Response
    {
        return $this->render('student_parent/index.html.twig', [
            'student_parents' => $studentParentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_student_parent_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StudentParentRepository $studentParentRepository): Response
    {
        $studentParent = new StudentParent();
        $form = $this->createForm(StudentParentType::class, $studentParent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentParentRepository->save($studentParent, true);

            return $this->redirectToRoute('app_student_parent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student_parent/new.html.twig', [
            'student_parent' => $studentParent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_parent_show', methods: ['GET'])]
    public function show(StudentParent $studentParent): Response
    {
        return $this->render('student_parent/show.html.twig', [
            'student_parent' => $studentParent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_student_parent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StudentParent $studentParent, StudentParentRepository $studentParentRepository): Response
    {
        $form = $this->createForm(StudentParentType::class, $studentParent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentParentRepository->save($studentParent, true);

            return $this->redirectToRoute('app_student_parent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student_parent/edit.html.twig', [
            'student_parent' => $studentParent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_parent_delete', methods: ['POST'])]
    public function delete(Request $request, StudentParent $studentParent, StudentParentRepository $studentParentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$studentParent->getId(), $request->request->get('_token'))) {
            $studentParentRepository->remove($studentParent, true);
        }

        return $this->redirectToRoute('app_student_parent_index', [], Response::HTTP_SEE_OTHER);
    }
}
