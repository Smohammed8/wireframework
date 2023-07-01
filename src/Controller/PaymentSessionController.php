<?php

namespace App\Controller;

use App\Entity\PaymentSession;
use App\Form\PaymentSessionType;
use App\Repository\PaymentSessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payment/session')]
class PaymentSessionController extends AbstractController
{
    #[Route('/', name: 'app_payment_session_index', methods: ['GET'])]
    public function index(PaymentSessionRepository $paymentSessionRepository): Response
    {
        return $this->render('payment_session/index.html.twig', [
            'payment_sessions' => $paymentSessionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_payment_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PaymentSessionRepository $paymentSessionRepository): Response
    {
        $paymentSession = new PaymentSession();
        $form = $this->createForm(PaymentSessionType::class, $paymentSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paymentSessionRepository->save($paymentSession, true);

            return $this->redirectToRoute('app_payment_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payment_session/new.html.twig', [
            'payment_session' => $paymentSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_payment_session_show', methods: ['GET'])]
    public function show(PaymentSession $paymentSession): Response
    {
        return $this->render('payment_session/show.html.twig', [
            'payment_session' => $paymentSession,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_payment_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PaymentSession $paymentSession, PaymentSessionRepository $paymentSessionRepository): Response
    {
        $form = $this->createForm(PaymentSessionType::class, $paymentSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paymentSessionRepository->save($paymentSession, true);

            return $this->redirectToRoute('app_payment_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payment_session/edit.html.twig', [
            'payment_session' => $paymentSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_payment_session_delete', methods: ['POST'])]
    public function delete(Request $request, PaymentSession $paymentSession, PaymentSessionRepository $paymentSessionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paymentSession->getId(), $request->request->get('_token'))) {
            $paymentSessionRepository->remove($paymentSession, true);
        }

        return $this->redirectToRoute('app_payment_session_index', [], Response::HTTP_SEE_OTHER);
    }
}
