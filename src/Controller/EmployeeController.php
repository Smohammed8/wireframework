<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use \Twig_Extension;
// use Andegna\DateTime;
use DateTime;
use Andegna\DateTimeFactory;
use Andegna\DateTime as et_date;

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Helper\DomPrint;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\Session;



#[Route('/employee')]
class EmployeeController extends AbstractController
{

    #[Route('/', name: 'app_employee_index', methods: ['GET'])]
    public function index(EmployeeRepository $employeeRepository,PaginatorInterface $paginator, Request $request): Response
    {
    
        $queryBuilder = $employeeRepository->getQuery($request->query->get('search'));
        $data = $paginator->paginate($queryBuilder, 
          $request->query->getInt('page', 1),
            4
         );

         return $this->render('employee/index.html.twig', [
            'employees' => $data,
         
        ]);


    }

   
    public function calculateAge($birthDate){

        $birthDate =new  DateTime($birthDate);
        $now = new  DateTime();
        $interval = $now->diff($birthDate);
        return $interval->format("%Y Years, %m months,%d days");

    }


    public function  getEmployeeID(){
        $uniqueNumber= rand(10000,99999);
        $currentYear = date('Y');
        $m = date('m');
        $d = date('d');
        $srudentID = $uniqueNumber.''.$currentYear.''.$m.''.$d;

         return  $srudentID;

    }


    #[Route('/new', name: 'app_employee_new', methods: ['GET', 'POST'])]

    public function new(Request $request, EmployeeRepository $employeeRepository): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


                    $ed  = $request->get('employementDate');
                    $dob  = $request->get('dateOfBirth');
                       

                    $emd   = explode('/', $ed);
                    $emdate  = DateTimeFactory::of($emd[2], $emd[1], $emd[0]);
       
                   
                    $sd   = explode('/', $dob);
                    $date_of_birth  = DateTimeFactory::of($sd[2], $sd[1], $sd[0]);
                
               // if ($date_of_birth->toGregorian() >= new \DateTimeImmutable()) {
                    if ($date_of_birth->toGregorian() >= new DateTime()) {
                    $this->addFlash('danger', 'Invalid date pf birth selections!');
                    return $this->redirectToRoute('app_employee_new', [], Response::HTTP_SEE_OTHER);
                
                    }

                   $uploadedFile = $form['photo']->getData();
                    if( $uploadedFile != null){
                    $destination = $this->getParameter('kernel.project_dir') . '/public/employee_photo';
                   // $newFilename = $employee->getId() . uniqid() . '.' . $uploadedFile->getClientOriginalName();
                     $newFilename = $employee->getId() . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                     $uploadedFile->move($destination, $newFilename);
                      $employee->setPhoto($newFilename);
                    } 
                      //  $this->addFlash('danger','No directoty found to store employee photo!'); 
        
            $employee->setFirstName (ucfirst(strtolower($form->get('firstName')->getData())));
            $employee->setFatherName (ucfirst(strtolower($form->get('fatherName')->getData())));
            $employee->setLastName (ucfirst(strtolower($form->get('lastName')->getData())));

            $employee->setDateOfBirth($date_of_birth->toGregorian());
            $employee->setEmployementDate ($emdate->toGregorian());
            $employee->setIdNumber($this->getEmployeeID());
            $employee->setCreatedAt(new \DateTimeImmutable());
            $employee->setUpdatedAt(new \DateTimeImmutable());
            $employeeRepository->save($employee, true);
            $this->addFlash('success', "The Employee has been successfully registered!");
            return $this->redirectToRoute('app_employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee/new.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_show', methods: ['GET'])]
    public function show(Employee $employee): Response
    {
        return $this->render('employee/show.html.twig', [
            'employee' => $employee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_employee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Employee $employee, EmployeeRepository $employeeRepository): Response
    {
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeRepository->save($employee, true);

            return $this->redirectToRoute('app_employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee/edit.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_delete', methods: ['POST'])]
    public function delete(Request $request, Employee $employee, EmployeeRepository $employeeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employee->getId(), $request->request->get('_token'))) {
            $employeeRepository->remove($employee, true);
        }

        return $this->redirectToRoute('app_employee_index', [], Response::HTTP_SEE_OTHER);
    }
}
