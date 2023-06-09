<?php

namespace App\Controller;

use App\Entity\Section;
use App\Entity\Grade;
use App\Form\SectionType;
use App\Repository\SectionRepository;
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

#[Route('/section')]
class SectionController extends AbstractController
{
    #[Route('/', name: 'app_section_index', methods: ['GET'])]
    public function index(SectionRepository $sectionRepository,PaginatorInterface $paginator, Request $request): Response
    {

        $queryBuilder = $sectionRepository->getQuery($request->query->get('search'));
        $data = $paginator->paginate($queryBuilder, $request->query->getInt('page', 1),
            10
         );
        return $this->render('section/all_list.html.twig', [
            'sections' => $data,
        ]);
    }




    #[Route('/new', name: 'app_section_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SectionRepository $sectionRepository): Response
    {
        $section = new Section();
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sectionRepository->save($section, true);


            $this->addFlash('success', "Section has been successfully deleted!");
            return $this->redirectToRoute('app_section',['id'=>$section->getGrade()->getId() ] );

            
          //  return $this->redirectToRoute('app_section_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('section/new.html.twig', [
            'section' => $section,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_section_show', methods: ['GET'])]
    public function show(Section $section): Response
    {
        return $this->render('section/show.html.twig', [
            'section' => $section,
        ]);
    }
    #[Route('/{id}/sections', name: 'app_section', methods: ['GET'])]
   public function getSection(Grade $grade,PaginatorInterface $paginator,SectionRepository $sectionRepository,Request $request){



  //  $queryBuilder = $sectionRepository->getQuery($request->query->get('search'));
     $data = $paginator->paginate($sectionRepository->getSections($grade), $request->query->getInt('page', 1),
        10
     );


    return $this->render('section/index.html.twig', [
        'sections' =>$data,
         'grade' => $grade->getName()
    ]);
}
    #[Route('/{id}/edit', name: 'app_section_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Section $section, SectionRepository $sectionRepository): Response
    {
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sectionRepository->save($section, true);
           
            $this->addFlash('success', "Section has been successfully registered!");
            return $this->redirectToRoute('app_section',['id'=>$section->getGrade()->getId() ] );
             }

        return $this->render('section/edit.html.twig', [
            'section' => $section,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_section_delete', methods: ['POST'])]
    public function delete(Request $request, Section $section, SectionRepository $sectionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$section->getId(), $request->request->get('_token'))) {
           
            $sectionRepository->remove($section, true);
        }
        $this->addFlash('success', "Section has been successfully deleted!");
        return $this->redirectToRoute('app_section',['id'=>$section->getGrade()->getId() ] );

    }
}
