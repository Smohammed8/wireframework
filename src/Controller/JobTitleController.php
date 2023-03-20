<?php

namespace App\Controller;

use App\Entity\JobTitle;
use App\Form\JobTitleType;
use App\Repository\JobTitleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/job/title')]
class JobTitleController extends AbstractController
{
    #[Route('/', name: 'app_job_title_index', methods: ['GET'])]
    public function index(JobTitleRepository $jobTitleRepository): Response
    {
        return $this->render('job_title/index.html.twig', [
            'job_titles' => $jobTitleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_job_title_new', methods: ['GET', 'POST'])]
    public function new(Request $request, JobTitleRepository $jobTitleRepository): Response
    {
        $jobTitle = new JobTitle();
        $form = $this->createForm(JobTitleType::class, $jobTitle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobTitleRepository->save($jobTitle, true);

            return $this->redirectToRoute('app_job_title_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('job_title/new.html.twig', [
            'job_title' => $jobTitle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_job_title_show', methods: ['GET'])]
    public function show(JobTitle $jobTitle): Response
    {
        return $this->render('job_title/show.html.twig', [
            'job_title' => $jobTitle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_job_title_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, JobTitle $jobTitle, JobTitleRepository $jobTitleRepository): Response
    {
        $form = $this->createForm(JobTitleType::class, $jobTitle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobTitleRepository->save($jobTitle, true);

            return $this->redirectToRoute('app_job_title_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('job_title/edit.html.twig', [
            'job_title' => $jobTitle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_job_title_delete', methods: ['POST'])]
    public function delete(Request $request, JobTitle $jobTitle, JobTitleRepository $jobTitleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jobTitle->getId(), $request->request->get('_token'))) {
            $jobTitleRepository->remove($jobTitle, true);
        }

        return $this->redirectToRoute('app_job_title_index', [], Response::HTTP_SEE_OTHER);
    }
}
