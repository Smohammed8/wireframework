<?php

namespace App\Controller;

use App\Entity\SalaryScale;
use App\Form\SalaryScaleType;
use App\Repository\SalaryScaleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/salary/scale')]
class SalaryScaleController extends AbstractController
{
    #[Route('/', name: 'app_salary_scale_index', methods: ['GET'])]
    public function index(SalaryScaleRepository $salaryScaleRepository): Response
    {
        return $this->render('salary_scale/index.html.twig', [
            'salary_scales' => $salaryScaleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_salary_scale_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SalaryScaleRepository $salaryScaleRepository): Response
    {
        $salaryScale = new SalaryScale();
        $form = $this->createForm(SalaryScaleType::class, $salaryScale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $salaryScaleRepository->save($salaryScale, true);

            return $this->redirectToRoute('app_salary_scale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('salary_scale/new.html.twig', [
            'salary_scale' => $salaryScale,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_salary_scale_show', methods: ['GET'])]
    public function show(SalaryScale $salaryScale): Response
    {
        return $this->render('salary_scale/show.html.twig', [
            'salary_scale' => $salaryScale,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_salary_scale_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SalaryScale $salaryScale, SalaryScaleRepository $salaryScaleRepository): Response
    {
        $form = $this->createForm(SalaryScaleType::class, $salaryScale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $salaryScaleRepository->save($salaryScale, true);

            return $this->redirectToRoute('app_salary_scale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('salary_scale/edit.html.twig', [
            'salary_scale' => $salaryScale,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_salary_scale_delete', methods: ['POST'])]
    public function delete(Request $request, SalaryScale $salaryScale, SalaryScaleRepository $salaryScaleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salaryScale->getId(), $request->request->get('_token'))) {
            $salaryScaleRepository->remove($salaryScale, true);
        }

        return $this->redirectToRoute('app_salary_scale_index', [], Response::HTTP_SEE_OTHER);
    }
}
