<?php

namespace App\Controller;

use App\Entity\SubjectAssignment;
use App\Form\SubjectAssignmentType;
use App\Helper\AmharicHelper;
use App\Repository\SubjectAssignmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/subject-assignment')]
class SubjectAssignmentController extends AbstractController
{
    #[Route('/', name: 'app_subject_assignment_index', methods: ['GET'])]
    public function index(SubjectAssignmentRepository $subjectAssignmentRepository): Response
    {
        return $this->render('subject_assignment/index.html.twig', [
            'subject_assignments' => $subjectAssignmentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_subject_assignment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SubjectAssignmentRepository $subjectAssignmentRepository): Response
    {
        $subjectAssignment = new SubjectAssignment();
        $form = $this->createForm(SubjectAssignmentType::class, $subjectAssignment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $subjectAssignment->setYear(AmharicHelper::getCurrentYear());
            $subjectAssignmentRepository->save($subjectAssignment, true);
            $this->addFlash('success','Teacher has been assigned successfully for given a subject!'); 

            return $this->redirectToRoute('app_subject_assignment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('subject_assignment/new.html.twig', [
            'subject_assignment' => $subjectAssignment,
            'form' => $form,
            'cyear' => AmharicHelper::getCurrentYear()
        ]);
    }

    #[Route('/{id}', name: 'app_subject_assignment_show', methods: ['GET'])]
    public function show(SubjectAssignment $subjectAssignment): Response
    {
        return $this->render('subject_assignment/show.html.twig', [
            'subject_assignment' => $subjectAssignment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_subject_assignment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SubjectAssignment $subjectAssignment, SubjectAssignmentRepository $subjectAssignmentRepository): Response
    {
        $form = $this->createForm(SubjectAssignmentType::class, $subjectAssignment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subjectAssignmentRepository->save($subjectAssignment, true);

            return $this->redirectToRoute('app_subject_assignment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('subject_assignment/edit.html.twig', [
            'subject_assignment' => $subjectAssignment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_subject_assignment_delete', methods: ['POST'])]
    public function delete(Request $request, SubjectAssignment $subjectAssignment, SubjectAssignmentRepository $subjectAssignmentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subjectAssignment->getId(), $request->request->get('_token'))) {
            $subjectAssignmentRepository->remove($subjectAssignment, true);
        }

        return $this->redirectToRoute('app_subject_assignment_index', [], Response::HTTP_SEE_OTHER);
    }
}
