<?php

namespace App\Controller;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Dompdf\Dompdf;
use Dompdf\Options;


#[Route('/user')]
class UserController extends AbstractController
{
   

    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository,PaginatorInterface $paginator, Request $request): Response
    {
   
    $queryBuilder = $userRepository->getQuery($request->query->get('search'));
        $data = $paginator->paginate($queryBuilder, 
          $request->query->getInt('page', 1),
            10
         );

        return $this->render('user/index.html.twig', [
            'users' => $data,
           // 'getTotalItemCount'=> $userRepository->total_users()
        ]);
    }

    #[Route('/teachers', name: 'app_teachers_index', methods: ['GET'])]
    public function getTeacher(UserRepository $userRepository,PaginatorInterface $paginator, Request $request): Response
    {
   
        $queryBuilder = $userRepository->getTeachers();
        $data = $paginator->paginate($queryBuilder, 
          $request->query->getInt('page', 1),
            10
         );

        return $this->render('user/index.html.twig', [
            'users' => $data,
            'list' =>'List of teachers'
        ]);
    }

    #[Route('/parents', name: 'app_parents_index', methods: ['GET'])]
    public function getParents(UserRepository $userRepository,PaginatorInterface $paginator, Request $request): Response
    {
   
    $queryBuilder = $userRepository->getParents();
        $data = $paginator->paginate($queryBuilder, 
          $request->query->getInt('page', 1),
            10
         );
        return $this->render('user/index.html.twig', [
            'users' => $data,
            'list' =>'List of parents'
        ]);
    }

    #[Route('/committee', name: 'app_committee_index', methods: ['GET'])]
    public function getCommitte(UserRepository $userRepository,PaginatorInterface $paginator, Request $request): Response
    {
   
    $queryBuilder = $userRepository->getCommittee();
        $data = $paginator->paginate($queryBuilder, 
          $request->query->getInt('page', 1),
            10
         );
        return $this->render('user/index.html.twig', [
            'users' => $data,
            'list' => 'List of School Committee'
        ]);
    }



    #[Route('/profile', name: 'profile', methods: ['GET'])]
    public function profile(Request $request, UserRepository $userRepository): Response
    {
        return $this->render('user/profile.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository,ManagerRegistry $doctrine, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $roles = (array)$request->request->all('user')['roles'];
            $user->setRoles($roles);
            $user->setCreatedAt(new \DateTime);
            $user->setLastLogin(null);
            $user->setPhoto(null);
            $user->setStatus(1);
            $user->setUserName($this->get_username($user->getFirstName(), $user->getFatherName(),$doctrine));

            $password = $this->randomPassword();

            $user->setPassword($hasher->hashPassword($user, $password));

           // $user->setRegisteredBy($this->getUser());

            $userRepository->save($user, true);
            $this->addFlash('success', "User Registered");
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    // public function show(User $user): Response
    // {
    //     return $this->render('user/show.html.twig', [
    //         'user' => $user,
    //     ]);
    // }


    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {

         return $this->render('user/profile.html.twig', [
            'user' => $user,
           
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    function get_username($first, $middle, $doctrine)
    {
        $string_name = $first . " " . $middle;
        $rand_no = 10;
        //$userRepository = $this->getDoctrine()->getManager()->getRepository(User::class);
        $userRepository  = $doctrine->getManager()->getRepository(User::class);
        while (true) {
            $username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
            $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part
            $part1 = (!empty($username_parts[0])) ? substr($username_parts[0], 0, rand(4, 6)) : ""; //cut fi rs t  name to 8 letters
            $part2 = (!empty($username_parts[1])) ? substr($username_parts[1], 0, rand(3, 5)) : ""; //cut se co n d name to 5 letters
            $username = $part1 . $part2; //str _shuffle to randomly shuffle all characters 
            if (!$userRepository->findOneBy(['username' => $username]))
                break;
        }
        return $username;
    }

    static function randomPassword()
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    

       //////////////////////////////////////////////////
       #[Route('/print/{id}', name: 'user_info_print', methods: ['GET', 'POST'])]
       public function PrintCredntial(Request $request,User $user, ManagerRegistry  $doctrine, UserPasswordHasherInterface $hasher): Response
       {
           //  $this->denyAccessUnlessGranted('rst_pswd');
         //  $user = $user->getRoles();
           if (in_array("ROLE_SUPERADMIN", $user->getRoles())) {
               $this->addFlash('warning', "Cannot Print Adminstrator Credential!!! ");
               return  $this->redirectToRoute("app_user_index");
           }
           $password = $this->randomPassword();
           $user->setPassword($hasher->hashPassword($user, $password));
           $doctrine->getManager()->flush();
           $pdfOptions = new Options();
           $pdfOptions->set('defaultFont', 'Arial');
           $pdfOptions->set('isRemoteEnabled', true);
           $dompdf = new Dompdf($pdfOptions);
   
           $res = $this->renderView('user/print.creadentials.html.twig', [
               "user" => $user, 
               'password' => $password,
               'phone'=>$user->getPhone(),
               'email'=>$user->getEmail(),
             //  'sex'=>$user->getSex()
   
           
           
           ]);
           //$date = new DateTime('now');
           $dompdf->loadHtml($res);
           $dompdf->setPaper('A5', 'Portrait');
   
           // Render the HTML as PDF
           $dompdf->render();
           $dompdf->stream($user->getFirstName() . ".pdf", [
               "Attachment" => true
           ]);
       }
   //////////////////////////////////////////////////////////////////////////

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
