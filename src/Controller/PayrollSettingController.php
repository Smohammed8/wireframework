<?php

namespace App\Controller;

use App\Entity\PayrollSetting;
use App\Form\PayrollSettingType;
use App\Repository\PayrollSettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payroll/setting')]
class PayrollSettingController extends AbstractController
{
    #[Route('/', name: 'app_payroll_setting_index', methods: ['GET'])]
    public function index(PayrollSettingRepository $payrollSettingRepository): Response
    {
        return $this->render('payroll_setting/index.html.twig', [
            'payroll_settings' => $payrollSettingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_payroll_setting_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PayrollSettingRepository $payrollSettingRepository): Response
    {
        $payrollSetting = new PayrollSetting();
        $form = $this->createForm(PayrollSettingType::class, $payrollSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $payrollSettingRepository->save($payrollSetting, true);

            return $this->redirectToRoute('app_payroll_setting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payroll_setting/new.html.twig', [
            'payroll_setting' => $payrollSetting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_payroll_setting_show', methods: ['GET'])]
    public function show(PayrollSetting $payrollSetting): Response
    {
        return $this->render('payroll_setting/show.html.twig', [
            'payroll_setting' => $payrollSetting,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_payroll_setting_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PayrollSetting $payrollSetting, PayrollSettingRepository $payrollSettingRepository): Response
    {
        $form = $this->createForm(PayrollSettingType::class, $payrollSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $payrollSettingRepository->save($payrollSetting, true);

            return $this->redirectToRoute('app_payroll_setting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payroll_setting/edit.html.twig', [
            'payroll_setting' => $payrollSetting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_payroll_setting_delete', methods: ['POST'])]
    public function delete(Request $request, PayrollSetting $payrollSetting, PayrollSettingRepository $payrollSettingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$payrollSetting->getId(), $request->request->get('_token'))) {
            $payrollSettingRepository->remove($payrollSetting, true);
        }

        return $this->redirectToRoute('app_payroll_setting_index', [], Response::HTTP_SEE_OTHER);
    }
}
