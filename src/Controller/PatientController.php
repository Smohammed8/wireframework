<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
#[Route('/patient')]
class PatientController extends AbstractController
{

    #[Route('/', name: 'app_patient_index', methods: ['GET'])]
    public function index(PatientRepository $patientRepository,PaginatorInterface $paginator, Request $request): Response
    {
   
    $queryBuilder = $patientRepository->getQuery($request->query->get('search'));
        $data = $paginator->paginate($queryBuilder, 
          $request->query->getInt('page', 1),
            15
         );

         return $this->render('patient/index.html.twig', [
            'patients' => $data,
           // 'getTotalItemCount'=> $userRepository->total_users()
        ]);
    }



    #[Route('/new', name: 'app_patient_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PatientRepository $patientRepository): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patientRepository->save($patient, true);

            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/search', name: 'ajax_search', methods: ['GET'])]

    public function searchAction(Request $request, PatientRepository $patientRepository)
    {
   
  
        $requestString = $request->get('q');
        $entities = $patientRepository->searchResult($requestString);


        if(!$entities) {
            $result['entities']['error'] = '<p style="color:red;"> No patient foound! </p>';
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }
  
        return new Response(json_encode($result));
    }
  
  
    public function getRealEntities($entities){
  
      foreach ($entities as $entity){
          $realEntities[$entity->getId()] = $entity->getFirstName().' '.$entity->getMiddleName().'   '.$entity->getLastName().'- <u>'.$entity->getEmr().'</u>';
      }
  
      return $realEntities;
  }


    #[Route('/{id}', name: 'app_patient_show', methods: ['GET'])]
    public function show(Patient $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_patient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Patient $patient, PatientRepository $patientRepository): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patientRepository->save($patient, true);

            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_patient_delete', methods: ['POST'])]
    public function delete(Request $request, Patient $patient, PatientRepository $patientRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->request->get('_token'))) {
            $patientRepository->remove($patient, true);
        }

        return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
    }
}
