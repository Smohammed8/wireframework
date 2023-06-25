<?php

namespace App\Controller;

use App\Entity\SectionHead;
use App\Form\SectionHeadType;
use App\Repository\SectionHeadRepository;
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
use Knp\Component\Pager\PaginatorInterface;

#[Route('/section-head')]
class SectionHeadController extends AbstractController
{
    #[Route('/', name: 'app_section_head_index', methods: ['GET'])]
    public function index(SectionHeadRepository $sectionHeadRepository,PaginatorInterface $paginator, Request $request): Response
    {

        $queryBuilder = $sectionHeadRepository->getQuery($request->query->get('search'));
        $data = $paginator->paginate($queryBuilder, $request->query->getInt('page', 1),
            1
    );
        return $this->render('section_head/index.html.twig', [
            'section_heads' => $data,
        ]);
    }

    #[Route('/new', name: 'app_section_head_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SectionHeadRepository $sectionHeadRepository): Response
    {
        $sectionHead = new SectionHead();
        $form = $this->createForm(SectionHeadType::class, $sectionHead);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sectionHead->setYear(AmharicHelper::getCurrentYear());
            $sectionHeadRepository->save($sectionHead, true);
            $this->addFlash('success','Section has been assigned successfully by section head!'); 

            return $this->redirectToRoute('app_section_head_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('section_head/new.html.twig', [
            'section_head' => $sectionHead,
            'form' => $form,
            'cyear' => AmharicHelper::getCurrentYear()
        ]);
    }

    #[Route('/{id}', name: 'app_section_head_show', methods: ['GET'])]
    public function show(SectionHead $sectionHead): Response
    {
        return $this->render('section_head/show.html.twig', [
            'section_head' => $sectionHead,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_section_head_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SectionHead $sectionHead, SectionHeadRepository $sectionHeadRepository): Response
    {
        $form = $this->createForm(SectionHeadType::class, $sectionHead);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sectionHeadRepository->save($sectionHead, true);

            return $this->redirectToRoute('app_section_head_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('section_head/edit.html.twig', [
            'section_head' => $sectionHead,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_section_head_delete', methods: ['POST'])]
    public function delete(Request $request, SectionHead $sectionHead, SectionHeadRepository $sectionHeadRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sectionHead->getId(), $request->request->get('_token'))) {
            $sectionHeadRepository->remove($sectionHead, true);
        }

        return $this->redirectToRoute('app_section_head_index', [], Response::HTTP_SEE_OTHER);
    }
}
