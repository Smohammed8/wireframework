<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(StudentRepository $studentRepository, UserRepository $userRepository ): Response
    {
        return $this->render('dashboard/index.html.twig', [

            'students' => $studentRepository->findAll(),
            'users'     =>$userRepository->findAll(),
        ]);
    }
}
