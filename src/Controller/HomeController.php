<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LeaveTypeRepository;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(LeaveTypeRepository $leaveTypeRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'leave_types' => $leaveTypeRepository->findAll(),
        ]);
    }
}
