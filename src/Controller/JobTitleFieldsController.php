<?php

namespace App\Controller;

use App\Entity\JobTitleFields;
use App\Form\JobTitleFieldsType;
use App\Repository\JobTitleFieldsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/job/title/fields')]
class JobTitleFieldsController extends AbstractController
{
    #[Route('/', name: 'app_job_title_fields_index', methods: ['GET'])]
    public function index(JobTitleFieldsRepository $jobTitleFieldsRepository): Response
    {
        return $this->render('job_title_fields/index.html.twig', [
            'job_title_fields' => $jobTitleFieldsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_job_title_fields_new', methods: ['GET', 'POST'])]
    public function new(Request $request, JobTitleFieldsRepository $jobTitleFieldsRepository): Response
    {
        $jobTitleField = new JobTitleFields();
        $form = $this->createForm(JobTitleFieldsType::class, $jobTitleField);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobTitleFieldsRepository->save($jobTitleField, true);

            return $this->redirectToRoute('app_job_title_fields_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('job_title_fields/new.html.twig', [
            'job_title_field' => $jobTitleField,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_job_title_fields_show', methods: ['GET'])]
    public function show(JobTitleFields $jobTitleField): Response
    {
        return $this->render('job_title_fields/show.html.twig', [
            'job_title_field' => $jobTitleField,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_job_title_fields_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, JobTitleFields $jobTitleField, JobTitleFieldsRepository $jobTitleFieldsRepository): Response
    {
        $form = $this->createForm(JobTitleFieldsType::class, $jobTitleField);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobTitleFieldsRepository->save($jobTitleField, true);

            return $this->redirectToRoute('app_job_title_fields_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('job_title_fields/edit.html.twig', [
            'job_title_field' => $jobTitleField,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_job_title_fields_delete', methods: ['POST'])]
    public function delete(Request $request, JobTitleFields $jobTitleField, JobTitleFieldsRepository $jobTitleFieldsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jobTitleField->getId(), $request->request->get('_token'))) {
            $jobTitleFieldsRepository->remove($jobTitleField, true);
        }

        return $this->redirectToRoute('app_job_title_fields_index', [], Response::HTTP_SEE_OTHER);
    }
}
