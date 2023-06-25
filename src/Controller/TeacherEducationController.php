<?php

namespace App\Controller;

use App\Entity\TeacherEducation;
use App\Form\TeacherEducationType;
use App\Repository\TeacherEducationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/teacher/education')]
class TeacherEducationController extends AbstractController
{
    #[Route('/', name: 'app_teacher_education_index', methods: ['GET'])]
    public function index(TeacherEducationRepository $teacherEducationRepository): Response
    {
        return $this->render('teacher_education/index.html.twig', [
            'teacher_educations' => $teacherEducationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_teacher_education_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TeacherEducationRepository $teacherEducationRepository): Response
    {
        $teacherEducation = new TeacherEducation();
        $form = $this->createForm(TeacherEducationType::class, $teacherEducation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teacherEducationRepository->save($teacherEducation, true);

            return $this->redirectToRoute('app_teacher_education_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teacher_education/new.html.twig', [
            'teacher_education' => $teacherEducation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_teacher_education_show', methods: ['GET'])]
    public function show(TeacherEducation $teacherEducation): Response
    {
        return $this->render('teacher_education/show.html.twig', [
            'teacher_education' => $teacherEducation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_teacher_education_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TeacherEducation $teacherEducation, TeacherEducationRepository $teacherEducationRepository): Response
    {
        $form = $this->createForm(TeacherEducationType::class, $teacherEducation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teacherEducationRepository->save($teacherEducation, true);

            return $this->redirectToRoute('app_teacher_education_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teacher_education/edit.html.twig', [
            'teacher_education' => $teacherEducation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_teacher_education_delete', methods: ['POST'])]
    public function delete(Request $request, TeacherEducation $teacherEducation, TeacherEducationRepository $teacherEducationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teacherEducation->getId(), $request->request->get('_token'))) {
            $teacherEducationRepository->remove($teacherEducation, true);
        }

        return $this->redirectToRoute('app_teacher_education_index', [], Response::HTTP_SEE_OTHER);
    }
}
