<?php

namespace App\Controller;

use App\Entity\JobTitleCategory;
use App\Form\JobTitleCategoryType;
use App\Repository\JobTitleCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/job/title/category')]
class JobTitleCategoryController extends AbstractController
{
    #[Route('/', name: 'app_job_title_category_index', methods: ['GET'])]
    public function index(JobTitleCategoryRepository $jobTitleCategoryRepository): Response
    {
        return $this->render('job_title_category/index.html.twig', [
            'job_title_categories' => $jobTitleCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_job_title_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, JobTitleCategoryRepository $jobTitleCategoryRepository): Response
    {
        $jobTitleCategory = new JobTitleCategory();
        $form = $this->createForm(JobTitleCategoryType::class, $jobTitleCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobTitleCategoryRepository->save($jobTitleCategory, true);

            return $this->redirectToRoute('app_job_title_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('job_title_category/new.html.twig', [
            'job_title_category' => $jobTitleCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_job_title_category_show', methods: ['GET'])]
    public function show(JobTitleCategory $jobTitleCategory): Response
    {
        return $this->render('job_title_category/show.html.twig', [
            'job_title_category' => $jobTitleCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_job_title_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, JobTitleCategory $jobTitleCategory, JobTitleCategoryRepository $jobTitleCategoryRepository): Response
    {
        $form = $this->createForm(JobTitleCategoryType::class, $jobTitleCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobTitleCategoryRepository->save($jobTitleCategory, true);

            return $this->redirectToRoute('app_job_title_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('job_title_category/edit.html.twig', [
            'job_title_category' => $jobTitleCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_job_title_category_delete', methods: ['POST'])]
    public function delete(Request $request, JobTitleCategory $jobTitleCategory, JobTitleCategoryRepository $jobTitleCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jobTitleCategory->getId(), $request->request->get('_token'))) {
            $jobTitleCategoryRepository->remove($jobTitleCategory, true);
        }

        return $this->redirectToRoute('app_job_title_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
