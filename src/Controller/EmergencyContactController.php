<?php

namespace App\Controller;

use App\Entity\EmergencyContact;
use App\Form\EmergencyContactType;
use App\Repository\EmergencyContactRepository;
use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Andegna\DateTimeFactory;
use Andegna\DateTime as et_date;
use App\Repository\RelationshipRepository;

#[Route('/emergency/contact')]
class EmergencyContactController extends AbstractController
{
    #[Route('/', name: 'app_emergency_contact_index', methods: ['GET'])]
    public function index(EmergencyContactRepository $emergencyContactRepository): Response
    {
        return $this->render('emergency_contact/index.html.twig', [
            'emergency_contacts' => $emergencyContactRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_emergency_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmergencyContactRepository $emergencyContactRepository): Response
    {
        $emergencyContact = new EmergencyContact();
        $form = $this->createForm(EmergencyContactType::class, $emergencyContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emergencyContactRepository->save($emergencyContact, true);

            return $this->redirectToRoute('app_emergency_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('emergency_contact/new.html.twig', [
            'emergency_contact' => $emergencyContact,
            'form' => $form,
        ]);
    }




    #[Route('/add_contact', name: 'add_contact', methods: ['POST'])]
    public function addContact( Request $request, EntityManagerInterface $entityManager, RelationshipRepository $relationshipRepository,  EmployeeRepository  $employeeRepository): Response
    {
        
        

          $emergencyContact = new EmergencyContact();

        if ($request->getMethod() == 'POST') {
            $employee_id   = $request->get('employee');
            $phone  = $request->get('phone');
            $relation_id = $request->get('relation');
            $fname       = $request->get('fname');
            $lname          = $request->get('lname');
            $employee = $employeeRepository->find($employee_id); // convert string ID to object
            $relation = $relationshipRepository->find($relation_id); // convert string ID to object
         
            $emergencyContact->setFirstName($fname);
            $emergencyContact->setLastName($lname);
            $emergencyContact->setRelationship($relation);
            $emergencyContact ->setPhone($phone);
            $emergencyContact ->setEmployee($employee);
            $entityManager->persist($emergencyContact );
            $entityManager->flush();
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    // 'data' => $result
                ]);
            }

            $this->addFlash('success', "The Employee emeregency contacts has been successfully added!");
            return $this->redirectToRoute('app_employee_show', ['id' =>$employee->getId()]);
       }
        return $this->redirectToRoute('app_employee_show', [
             
            // 'id' => $employee->getId(),
             'emergencyContact ' => $emergencyContact  
           // 'form' => $form
        ]);

    }

    #[Route('/{id}', name: 'app_emergency_contact_show', methods: ['GET'])]
    public function show(EmergencyContact $emergencyContact): Response
    {
        return $this->render('emergency_contact/show.html.twig', [
            'emergency_contact' => $emergencyContact,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_emergency_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EmergencyContact $emergencyContact, EmergencyContactRepository $emergencyContactRepository): Response
    {
        $form = $this->createForm(EmergencyContactType::class, $emergencyContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emergencyContactRepository->save($emergencyContact, true);

         //   return $this->redirectToRoute('app_emergency_contact_index', [], Response::HTTP_SEE_OTHER);

            $this->addFlash('success', "Successfylly deleted!");

            return $this->redirectToRoute('app_employee_show', ['id' =>$emergencyContact->getEmployee()->getId()]);
        }

        return $this->renderForm('emergency_contact/edit.html.twig', [
            'emergency_contact' => $emergencyContact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_emergency_contact_delete', methods: ['POST'])]
    public function delete(Request $request, EmergencyContact $emergencyContact, EmergencyContactRepository $emergencyContactRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emergencyContact->getId(), $request->request->get('_token'))) {
            $emergencyContactRepository->remove($emergencyContact, true);
        }

          $this->addFlash('success', "Successfylly deleted!");

        return $this->redirectToRoute('app_employee_show', ['id' =>$emergencyContact->getEmployee()->getId()]);
    }
}
