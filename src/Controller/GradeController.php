<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Entity\Section;
use App\Form\GradeType;
use App\Repository\GradeRepository;
use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/grade')]
class GradeController extends AbstractController
{
    #[Route('/', name: 'app_grade_index', methods: ['GET'])]
    public function index(GradeRepository $gradeRepository): Response
    {
        return $this->render('grade/index.html.twig', [
            'grades' => $gradeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_grade_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GradeRepository $gradeRepository): Response
    {
        $grade = new Grade();
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gradeRepository->save($grade, true);

            return $this->redirectToRoute('app_grade_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('grade/new.html.twig', [
            'grade' => $grade,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_grade_show', methods: ['GET'])]
    public function show(Grade $grade): Response
    {
        return $this->render('grade/show.html.twig', [
            'grade' => $grade,
        ]);
    }


// #[Route('/{id}/employees', name: 'app_employees', methods: ['GET'])]
// public function getEmployee(Unit $unit,PaginatorInterface $paginator, UnitRepository $unitRepository,Request $request){

//     $units = $unitRepository->getEmployees($unit);
//     $data = $paginator->paginate($units , $request->query->getInt('page', 1),10);
//         return $this->render('unit/employees.html.twig', [
//         'units' =>$data,
//         'parent_unit' => $unit->getName()
//     ]);
// }


    #[Route('/{id}/edit', name: 'app_grade_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Grade $grade, GradeRepository $gradeRepository): Response
    {
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gradeRepository->save($grade, true);

            return $this->redirectToRoute('app_grade_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('grade/edit.html.twig', [
            'grade' => $grade,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grade_delete', methods: ['POST'])]
    public function delete(Request $request, Grade $grade, GradeRepository $gradeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grade->getId(), $request->request->get('_token'))) {
            $gradeRepository->remove($grade, true);
        }

        return $this->redirectToRoute('app_grade_index', [], Response::HTTP_SEE_OTHER);
    }
}
