<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\User;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Helper\Constants;
use App\Helper\AmharicHelper;
use App\Helper\DomPrint;
use Dompdf\Dompdf;
use Dompdf\Options;
use Andegna\DateTime as AD;
use DateTime;
use Date;
use Andegna\DateTimeFactory;
use Andegna\DateTime as et_date;
use App\Repository\AcademicSessionRepository;
use App\Repository\GradeRepository;
use App\Repository\LeaveTypeRepository;
use App\Repository\MonthRepository;
use App\Repository\RegionRepository;
use App\Repository\RegistrationRepository;
use App\Repository\RelationshipRepository;
use App\Repository\StudentParentRepository;
use App\Repository\StudentPaymentRepository;
use App\Repository\StudentUploadRepository;
use App\Repository\SubjectRepository;
use App\Repository\ZoneRepository;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/student')]
class StudentController extends AbstractController
{
    #[Route('/', name: 'app_student_index', methods: ['GET'])]
    public function index(StudentRepository $studentRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $queryBuilder = $studentRepository->getQuery($request->query->get('search'));
        $data = $paginator->paginate($queryBuilder, $request->query->getInt('page', 1),
            10
         );

        return $this->render('student/index.html.twig', [
            'students' => $data,
        ]);
    }

    #[Route('/search', name: 'ajax_search', methods: ['GET'])]

    public function searchAction(Request $request, StudentRepository $studentRepository)
    {
   
  
        $requestString = $request->get('q');
        $entities = $studentRepository->searchResult($requestString);
        if(!$entities) {
            $result['entities']['error'] = '<p style="color:red;"> No student found! </p>';
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }
  
        return new Response(json_encode($result));
    }
  
  
    public function getRealEntities($entities){
  
      foreach ($entities as $entity){
          $realEntities[$entity->getId()] = $entity->getFirstName().' '.$entity->getFatherName().'   '.$entity->getLastName().'- <u>'.$entity->getIdNumber().'</u>';
      }
  
      return $realEntities;
  }
    public function  getstudentID(){

        $cyear = AmharicHelper::getCurrentYear();
        $cmonth = AmharicHelper::getCurrentMonth();
        $cday = AmharicHelper::getCurrentDay();
        $uniqueNumber= rand(1000,9999);
        $currentYear = date('Y');
        $slash = '/';
        $m = date('m');
        $d = date('d');
        $srudentID = $uniqueNumber.''.$cday.''.$cmonth.''.$slash.''.$cyear;

         return  $srudentID;

    }

    #[Route('/new', name: 'app_student_new', methods: ['GET', 'POST'])]
    public function new(Request $request, 
    StudentRepository $studentRepository,
    RegionRepository $regionRepository,
    ZoneRepository $zoneRepository,
    
    ): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $phone = $request->get('phone');
            $dob  = $request->get('dob');

        // if ($date_of_birth->toGregorian() >= new \DateTimeImmutable()) {
        if (AmharicHelper::fromEthtoGre($dob)  >= new DateTime()) {
            $this->addFlash('danger', 'Invalid date of birth selections!');
            return $this->redirectToRoute('app_student_new', [], Response::HTTP_SEE_OTHER);
        
            }


                $phone = $studentRepository->findOneBy(['phone' =>$request->get('phone')]);

                $email = $studentRepository->findOneBy(['email' => $form->get('email')->getData()]);
            
                $idReturn = $this->getstudentID();
                $idNumber = $studentRepository->findOneBy(['idNumber' =>$idReturn]);

        
                if($idReturn  !== null){
                if(!is_null($idNumber)){
                $this->addFlash('danger', "The student Generated ID number (".$idReturn.")  is unxpectedly duplicated, please register agiain!");
                return $this->redirectToRoute('app_student_new', [], Response::HTTP_SEE_OTHER);
                
                }}
                if($request->get('phone') !== null){
                if(!is_null($phone)){
                $this->addFlash('danger', "The phone number you provided ".$request->get('phone')."  is already exist!");
                return $this->redirectToRoute('app_student_new', [], Response::HTTP_SEE_OTHER);
                
                }}
                if($form->get('email')->getData() !== null){
                if(!is_null($email)){

                $this->addFlash('danger', "The email you provideed  (".$form->get('email')->getData().") is already exist!");
                return $this->redirectToRoute('app_student_new', [], Response::HTTP_SEE_OTHER);
                
                }}
        

            $uploadedFile = $form['photo']->getData();
            if( $uploadedFile != null){
            $destination = $this->getParameter('kernel.project_dir') . '/public/student_photo';
                $newFilename = $student->getId() . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move($destination, $newFilename);
                $student->setPhoto($newFilename);
            } 
                //  $this->addFlash('danger','No directoty found to store student photo!'); 

            $student->setFirstName (ucfirst(strtolower($form->get('firstName')->getData())));
            $student->setFatherName (ucfirst(strtolower($form->get('fatherName')->getData())));
            $student->setLastName (ucfirst(strtolower($form->get('lastName')->getData())));

            $student->setDob(AmharicHelper::fromEthtoGre($dob));
            $student->setPhone($phone);
            $student->setUser($this->getUser());
            $student->setCreatedAt(new DateTime('now'));
            $student->setIdNumber($idReturn);
            $studentRepository->save($student, true);
            $this->addFlash('success','Student has been successfully registered!'); 
            return $this->redirectToRoute('app_student_show',['id'=>$student->getId() ] );

        }

        return $this->render('student/new.html.twig', [
            'student' => $student,
            'regions'=> $regionRepository->findAll(),
            'zones' =>$zoneRepository->findAll(),
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_show', methods: ['GET'])]
    public function show(Student $student,
    StudentUploadRepository $studentUploadRepository,
    RegistrationRepository $registrationRepository,
    LeaveTypeRepository $leaveTypeRepository,
    StudentParentRepository $studentParentRepository,
    PaginatorInterface $paginator,
    SubjectRepository $subjectRepository,
    GradeRepository $gradeRepository,
    RelationshipRepository $relationshipRepository,
    MonthRepository $monthRepository,
    StudentPaymentRepository $studentPaymentRepository,
    AcademicSessionRepository $academicSessionRepository,
    Request $request): Response
    {
        return $this->render('student/show.html.twig', [
            'student' => $student,
            'last'=> $registrationRepository->getLast($student),
          //  'regitsrations' =>$student->getRegistrations(),
           // 'registrations' => $paginator->paginate($student->getRegistrations(), $request->query->getInt('page', 1), 1),
            'registrations' => $paginator->paginate($registrationRepository->getQuery($student), $request->query->getInt('page', 1), 1),
            'student_uploads' => $paginator->paginate($studentUploadRepository->getQuery($request->query->get('search')), $request->query->getInt('page', 1), 5),
            'leave_types' => $paginator->paginate($leaveTypeRepository->getQuery($request->query->get('search')), $request->query->getInt('page', 1), 10),          
            'cyear' => AmharicHelper::getCurrentYear(),
            'cmonth' => AmharicHelper::getCurrentMonth(),
            'cday' => AmharicHelper::getCurrentDay(),
            'student_parents' => $studentParentRepository->findAll(),
            'subjects'=>$subjectRepository->findAll(),
            'grades' => $gradeRepository->findAll(),
            'relationships'  => $relationshipRepository->findAll(),
            'academic_sessions' => $academicSessionRepository->findAll(),
            'months' => $monthRepository->findAll(),
            //'student_payments' => $studentPaymentRepository->findAll()
            'student_payments' => $paginator->paginate($studentPaymentRepository->getQuery($student), $request->query->getInt('page', 1), 10),
        ]);
    }


 


    #[Route('/{id}/edit', name: 'app_student_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Student $student, StudentRepository $studentRepository): Response
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentRepository->save($student, true);

            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student/edit.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_delete', methods: ['POST'])]
    public function delete(Request $request, Student $student, StudentRepository $studentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$student->getId(), $request->request->get('_token'))) {
            $studentRepository->remove($student, true);
        }

        return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
    }
}
