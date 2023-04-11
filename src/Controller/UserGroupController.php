<?php

namespace App\Controller;

use App\Entity\UserGroup;
use App\Entity\User;
use App\Form\UserGroupType;
use App\Repository\UserGroupRepository;
use App\Repository\UserRepository;
use App\Repository\PermissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/user-group')]
class UserGroupController extends AbstractController
{
    #[Route('/', name: 'app_user_group_index', methods: ['GET'])]
    public function index(UserGroupRepository $userGroupRepository): Response
    {
        return $this->render('user_group/index.html.twig', [
            'user_groups' => $userGroupRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_group_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserGroupRepository $userGroupRepository): Response
    {
        $userGroup = new UserGroup();
        $form = $this->createForm(UserGroupType::class, $userGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userGroupRepository->save($userGroup, true);

            return $this->redirectToRoute('app_user_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_group/new.html.twig', [
            'user_group' => $userGroup,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_group_show', methods: ['GET'])]
    public function show(UserGroup $userGroup): Response
    {
        return $this->render('user_group/show.html.twig', [
            'user_group' => $userGroup,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_group_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserGroup $userGroup, UserGroupRepository $userGroupRepository): Response
    {
        $form = $this->createForm(UserGroupType::class, $userGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userGroupRepository->save($userGroup, true);

            return $this->redirectToRoute('app_user_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_group/edit.html.twig', [
            'user_group' => $userGroup,
            'form' => $form,
        ]);
    }


            /**
     * @Route("/{id}/permission", name="user_group_permission", methods={"GET","POST"})
     */
    public function permission(UserGroup $userGroup,Request $request,PermissionRepository $permissionRepository,UserGroupRepository $userGroupRepository){
        
        // $this->denyAccessUnlessGranted('ad_prmsn_to_grp');
 
        if($request->request->get('usergrouppermission')){
            $permissions = $permissionRepository->findAll();
               foreach ($permissions as $permission) {
             $userGroup->removePermission($permission);
            }
 
            $permissions=$permissionRepository->findBy(['id'=>$request->request->all('permission')]);
            foreach ($permissions as $permission) {
               
             $userGroup->addPermission($permission);
            }
            $userGroupRepository->save($userGroup, true);
            $this->addFlash('success', "Permission updated for a given group!");
        }
         return $this->render('user_group/show.html.twig', [
             'user_group' => $userGroup,
             'permissions' => $permissionRepository->findForUserGroup($userGroup->getPermissions()),
            
         ]);
  
 
 }
 
       /**
      * @Route("/{id}/activate", name="user_group_action", methods={"POST"})
      */
     public function action(UserGroup $userGroup,Request $request,UserGroupRepository $userGroupRepository){
        // $this->denyAccessUnlessGranted('edt_usr_grp');
 
         $userGroup->setIsActive($request->request->get('activateUserGroup'));
         //$userGroup->setUpdatedAt(new \DateTime());
         //$userGroup->setUpdatedBy($this->getUser());
         $userGroupRepository->save($userGroup, true);

        // $this->getDoctrine()->getManager()->flush();
         $this->addFlash('success'," User group successfully updated");
         return $this->redirectToRoute('app_user_group_index');
  
 
 
     }   
     
     /**
     * @Route("/{id}/users", name="user_group_users", methods={"GET","POST"})
     */
     public function user(UserGroup $userGroup,Request $request,UserRepository $userRepository,EntityManagerInterface $entityManager,UserGroupRepository $userGroupRepository){
    //  $this->denyAccessUnlessGranted('ad_usr_to_grp');
        if($request->request->get('usergroupuser')){
            $users = $userGroup->getUsers();
               foreach ($users as $user) {
             $userGroup->removeUser($user);
             }
            
            $users =$userRepository->findBy(['id'=>$request->request->all('user')]);
            foreach ($users as $user) {
             $userGroup->addUser($user);
          
            }
           
             $userGroupRepository->save($userGroup, true);
             $this->addFlash('success', "User updated in a given group!");
         
        }
    // dd($userRepository->findForUserGroup($userGroup->getUsers()));
         return $this->render('user_group/add.user.html.twig', [
             'user_group' => $userGroup,
             'users' => $userRepository->findForUserGroup($userGroup->getUsers()),
            
         ]);
         }



    #[Route('/{id}', name: 'app_user_group_delete', methods: ['POST'])]
    public function delete(Request $request, UserGroup $userGroup, UserGroupRepository $userGroupRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userGroup->getId(), $request->request->get('_token'))) {
            $userGroupRepository->remove($userGroup, true);
        }

        return $this->redirectToRoute('app_user_group_index', [], Response::HTTP_SEE_OTHER);
    }
}
