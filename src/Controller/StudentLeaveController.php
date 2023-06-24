<?php

namespace App\Controller;

use DateTime;
use Andegna\DateTimeFactory;
use App\Entity\StudentLeave;
use App\Entity\User;
use App\Helper\AmharicHelper;
use App\Form\StudentLeaveType;
use App\Repository\UserRepository;
use App\Repository\StudentLeaveRepository;
use App\Repository\LeaveRepository;
use App\Repository\LeaveTypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/student/leave')]
class StudentLeaveController extends AbstractController
{
    #[Route('/', name: 'app_student_leave_index', methods: ['GET'])]
    public function index(StudentLeaveRepository $studentLeaveRepository): Response
    {
        return $this->render('student_leave/index.html.twig', [
            'student_leaves' => $studentLeaveRepository->findAll(),
        ]);
    }


    #[Route('/sendRequest', name: 'app_send_request', methods: ['POST'])]
    public function sendRequest(UserRepository $userRepository, StudentLeaveRepository $studentLeaveRepository,EntityManagerInterface  $entityManager, Request $request, LeaveTypeRepository $leaveTypeRepository)
    {
      

           $studentLeave = new StudentLeave();
        if ($request->getMethod() == 'POST') {
            $reason = $request->get('reason');
            $typeid = $request->get('typeId');
            $st = $request->get('st');
            $en = $request->get('en');
           // $userId = $request->get('user');
           // $user  = $userRepository->find($userId);


         
            $startDate = AmharicHelper::fromEthtoGre($st);
            $endDate  = AmharicHelper::fromEthtoGre($en);

            if ($endDate <=   $startDate) {
            $this->addFlash('danger', 'Invalid date selections!');
       
         
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        
            }

            if ($endDate <=  new DateTime() ) {
                $this->addFlash('danger', 'Leave request for past days not permitted!');
           
             
                return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
            
                }

              $type  = $leaveTypeRepository->find($typeid);
              $studentLeave->setLeaveType($type);
              $studentLeave->setStartDate($startDate );
              $studentLeave->setEndDate($endDate);
              $studentLeave->setDescription($reason);
              $studentLeave->setStatus('Open');
              $studentLeave->setStudent($this->getUser()->getStudent());
              $studentLeave->setUser($this->getUser());
              $studentLeave->setCreatedAt(new  DateTime());
              $studentLeave->setApprovedAt(null);
              $studentLeave->setApprovedBy(null);
              $studentLeaveRepository->save($studentLeave, true);
            //   $entityManager->persist($studentLeave);
            //   $entityManager->flush();
              $this->addFlash('success', 'Your request has been sent successully!');
        
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
       }
    //    return $this->render('home/index.html.twig', [
    //     'employee_leave' => $studentLeave,
      
    // ]);
}

    #[Route('/new', name: 'app_student_leave_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StudentLeaveRepository $studentLeaveRepository): Response
    {
        $studentLeave = new StudentLeave();
        $form = $this->createForm(StudentLeaveType::class, $studentLeave);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentLeaveRepository->save($studentLeave, true);

            return $this->redirectToRoute('app_student_leave_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student_leave/new.html.twig', [
            'student_leave' => $studentLeave,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_leave_show', methods: ['GET'])]
    public function show(StudentLeave $studentLeave): Response
    {
        return $this->render('student_leave/show.html.twig', [
            'student_leave' => $studentLeave,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_student_leave_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StudentLeave $studentLeave, StudentLeaveRepository $studentLeaveRepository): Response
    {
        $form = $this->createForm(StudentLeaveType::class, $studentLeave);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentLeaveRepository->save($studentLeave, true);

            return $this->redirectToRoute('app_student_leave_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student_leave/edit.html.twig', [
            'student_leave' => $studentLeave,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_leave_delete', methods: ['POST'])]
    public function delete(Request $request, StudentLeave $studentLeave, StudentLeaveRepository $studentLeaveRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$studentLeave->getId(), $request->request->get('_token'))) {
            $studentLeaveRepository->remove($studentLeave, true);
        }

        return $this->redirectToRoute('app_student_leave_index', [], Response::HTTP_SEE_OTHER);
    }
}
