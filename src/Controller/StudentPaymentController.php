<?php

namespace App\Controller;

use App\Entity\StudentPayment;
use App\Form\StudentPaymentType;
use App\Helper\AmharicHelper;
use App\Repository\AcademicSessionRepository;
use App\Repository\MonthRepository;
use App\Repository\StudentPaymentRepository;
use App\Repository\StudentRepository;
use Container1kWy5is\getAcademicSessionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student-payment')]
class StudentPaymentController extends AbstractController
{
    #[Route('/', name: 'app_student_payment_index', methods: ['GET'])]
    public function index(StudentPaymentRepository $studentPaymentRepository): Response
    {
        return $this->render('student_payment/index.html.twig', [
            'student_payments' => $studentPaymentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_student_payment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StudentPaymentRepository $studentPaymentRepository): Response
    {
        $studentPayment = new StudentPayment();
        $form = $this->createForm(StudentPaymentType::class, $studentPayment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentPaymentRepository->save($studentPayment, true);

            return $this->redirectToRoute('app_student_payment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student_payment/new.html.twig', [
            'student_payment' => $studentPayment,
            'form' => $form,
        ]);
    }

    #[Route('/add_payment', name: 'add_payment', methods: ['POST'])]
    public function addstudentPayment( Request $request, AcademicSessionRepository $academicSessionRepository, MonthRepository $monthRepository,studentPaymentRepository $studentPaymentRepository, StudentRepository $studentRepository)
    {
       
         
       
          $studentPayment = new StudentPayment();
        if ($request->getMethod() == 'POST') {
            $student_id   = $request->get('student');
            $session_id  = $request->get('session');
            $amount  = $request->get('amount');
            $month_id  = $request->get('month');

            $session = $academicSessionRepository->find($session_id); // convert string ID to object

            $student = $studentRepository->find($student_id); // convert string ID to object
            $month = $monthRepository->find($month_id); // convert string ID to object
          
            $check =$studentPaymentRepository->findOneBy(['month' => $month, 'student'=>$student,'year'=>AmharicHelper::getCurrentYear()]);
            if(!is_null($check)){
                $this->addFlash('danger', "No duplicated student payment is permitted!");
                return $this->redirectToRoute('app_student_show', ['id' =>$student->getId()]);
             }
           
            $studentPayment->setMonth($month);
            $studentPayment->setStudent($student );
            $studentPayment->setAccademicSession($session);
            $studentPayment->setYear(AmharicHelper::getCurrentYear(),);
            $studentPayment->setAmount($amount);
            $studentPayment->setCreatedAt(new \DateTimeImmutable());
            $studentPayment->setCashier($this->getUser());
            $studentPaymentRepository->save($studentPayment, true);
            $this->addFlash('success', "The student payment has been successfully added!");
            return $this->redirectToRoute('app_student_show', ['id' =>$student->getId()]);
            }

        return $this->render('student/show.html.twig', [
            //'student' =>$student 
    
    ]);

        
    }

    #[Route('/{id}', name: 'app_student_payment_show', methods: ['GET'])]
    public function show(StudentPayment $studentPayment): Response
    {
        return $this->render('student_payment/show.html.twig', [
            'student_payment' => $studentPayment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_student_payment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StudentPayment $studentPayment, StudentPaymentRepository $studentPaymentRepository): Response
    {
        $form = $this->createForm(StudentPaymentType::class, $studentPayment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentPaymentRepository->save($studentPayment, true);

            return $this->redirectToRoute('app_student_payment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student_payment/edit.html.twig', [
            'student_payment' => $studentPayment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_payment_delete', methods: ['POST'])]
    public function delete(Request $request, StudentPayment $studentPayment, StudentPaymentRepository $studentPaymentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$studentPayment->getId(), $request->request->get('_token'))) {
            $studentPaymentRepository->remove($studentPayment, true);
        }

        return $this->redirectToRoute('app_student_payment_index', [], Response::HTTP_SEE_OTHER);
    }
}
