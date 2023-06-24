<?php

namespace App\Controller;

use App\Entity\StudentUpload;
use App\Form\StudentUploadType;
use App\Repository\StudentUploadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student/upload')]
class StudentUploadController extends AbstractController
{
    #[Route('/', name: 'app_student_upload_index', methods: ['GET'])]
    public function index(StudentUploadRepository $studentUploadRepository): Response
    {
        return $this->render('student_upload/index.html.twig', [
            'student_uploads' => $studentUploadRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_student_upload_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StudentUploadRepository $studentUploadRepository): Response
    {
        $studentUpload = new StudentUpload();
        $form = $this->createForm(StudentUploadType::class, $studentUpload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentUploadRepository->save($studentUpload, true);

            return $this->redirectToRoute('app_student_upload_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student_upload/new.html.twig', [
            'student_upload' => $studentUpload,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_upload_show', methods: ['GET'])]
    public function show(StudentUpload $studentUpload): Response
    {
        return $this->render('student_upload/show.html.twig', [
            'student_upload' => $studentUpload,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_student_upload_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StudentUpload $studentUpload, StudentUploadRepository $studentUploadRepository): Response
    {
        $form = $this->createForm(StudentUploadType::class, $studentUpload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentUploadRepository->save($studentUpload, true);

            return $this->redirectToRoute('app_student_upload_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student_upload/edit.html.twig', [
            'student_upload' => $studentUpload,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_upload_delete', methods: ['POST'])]
    public function delete(Request $request, StudentUpload $studentUpload, StudentUploadRepository $studentUploadRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$studentUpload->getId(), $request->request->get('_token'))) {
            $studentUploadRepository->remove($studentUpload, true);
        }

        return $this->redirectToRoute('app_student_upload_index', [], Response::HTTP_SEE_OTHER);
    }
}
