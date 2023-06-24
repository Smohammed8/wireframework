<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Entity\Grade;
use App\Form\SubjectType;
use App\Repository\SubjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/subject')]
class SubjectController extends AbstractController
{
    #[Route('/', name: 'app_subject_index', methods: ['GET'])]
    public function index(SubjectRepository $subjectRepository): Response
    {
        return $this->render('subject/all_list.html.twig', [
            'subjects' => $subjectRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_subject_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SubjectRepository $subjectRepository): Response
    {
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subjectRepository->save($subject, true);

            $this->addFlash('success', "Subject has been successfully added!");
            return $this->redirectToRoute('app_subject',['id'=>$subject->getGrade()->getId() ] );


           // return $this->redirectToRoute('app_subject_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('subject/new.html.twig', [
            'subject' => $subject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_subject_show', methods: ['GET'])]
    public function show(Subject $subject): Response
    {
        return $this->render('subject/show.html.twig', [
            'subject' => $subject,
        ]);
    }

    #[Route('/{id}/subjects', name: 'app_subject', methods: ['GET'])]
    public function getSubject(Grade $grade,SubjectRepository $subjectRepository,Request $request){
 
 
     return $this->render('subject/index.html.twig', [
         'subjects' =>  $subjectRepository->getSubjects($grade),
         'grade' => $grade->getName()
     ]);
     }
    #[Route('/{id}/edit', name: 'app_subject_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Subject $subject, SubjectRepository $subjectRepository): Response
    {
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subjectRepository->save($subject, true);

            $this->addFlash('success', "Subject has been successfully registered!");
            return $this->redirectToRoute('app_subject',['id'=>$subject->getGrade()->getId() ] );

          
        }

        return $this->render('subject/edit.html.twig', [
            'subject' => $subject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_subject_delete', methods: ['POST'])]
    public function delete(Request $request, Subject $subject, SubjectRepository $subjectRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subject->getId(), $request->request->get('_token'))) {
            $subjectRepository->remove($subject, true);
        }

        $this->addFlash('success', "Subject has been successfully deleted!");
        return $this->redirectToRoute('app_subject',['id'=>$subject->getGrade()->getId() ] );


      //  return $this->redirectToRoute('app_subject_index', [], Response::HTTP_SEE_OTHER);
    }
}
