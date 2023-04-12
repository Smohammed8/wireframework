<?php

namespace App\Controller;

use App\Repository\EmployeeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index( EmployeeRepository $employeeRepository, UserRepository $userRepository ): Response
    {
        return $this->render('dashboard/index.html.twig', [

            'employees' => $employeeRepository->findAll(),
            'users'     =>$userRepository->findAll(),
        ]);
    }
}
