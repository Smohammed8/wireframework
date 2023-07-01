<?php

namespace App\Controller;

use App\Entity\StudentParent;
use App\Form\StudentParentType;
use App\Repository\RelationshipRepository;
use App\Repository\StudentParentRepository;
use App\Repository\StudentRepository;
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
    #[Route('/add_parent', name: 'add_parent', methods: ['POST'])]
    public function addstudentParent( Request $request,RelationshipRepository $relationshipRepository,StudentParentRepository $studentParentRepository, StudentRepository $studentRepository)
    {
       
         
          $studentParent = new StudentParent();
        if ($request->getMethod() == 'POST') {
            $student_id   = $request->get('student');
          //  dd( $employee_id );
            $fname  = $request->get('fname');
            $lname  = $request->get('lname');
            $address = $request->get('address');
            $relation_id = $request->get('relation');
            $email = $request->get('email');
            $phone = $request->get('phone');
            $student = $studentRepository->find($student_id); // convert string ID to object
            $relation = $relationshipRepository->find($relation_id); // convert string ID to object
          
            $check =$studentParentRepository->findOneBy(['phone' => $phone, 'email'=>$email]);
            if(!is_null($check)){
                $this->addFlash('danger', "No duplicated student parent is permitted!");
                return $this->redirectToRoute('app_student_show', ['id' =>$student->getId()]);
             }
            $studentParent->setRelation($relation);
            $studentParent->setPhone($phone);
            $studentParent->setFirstName($fname);
            $studentParent->setFatherName($lname);
            $studentParent->setStudent($student );
            $studentParent->setEmail($email);
            $studentParent->setAddress($address);
            $studentParent->setCreatedAt(new \DateTimeImmutable());
            $studentParent->setUser($this->getUser());
            $studentParentRepository->save($studentParent, true);
            $this->addFlash('success', "The student parent has been successfully added!");
            return $this->redirectToRoute('app_student_show', ['id' =>$student->getId()]);
            }

        return $this->render('student/show.html.twig', [
            //'student' =>$student 
    
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

          
            $this->addFlash('success', "The student parent has been successfully updated!");
            return $this->redirectToRoute('app_student_show', ['id' =>$studentParent->getStudent()->getId()]);

            

         //   return $this->redirectToRoute('app_student_parent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student_parent/edit.html.twig', [
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
        $this->addFlash('success', "The student parent has been successfully deleted!");
        return $this->redirectToRoute('app_student_show', ['id' =>$studentParent->getStudent()->getId()]);


       // return $this->redirectToRoute('app_student_parent_index', [], Response::HTTP_SEE_OTHER);
    }
}
