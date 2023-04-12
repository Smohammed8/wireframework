<?php 
namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;
class MainVoter extends Voter
{ 
    private $session;
    public function __construct( private Security $security ) {

        $this->security = $security;
    }

 

    protected function supports($attribute, $subject) : bool
    {
  
        $permission=$this->session->get("PERMISSION");
        if(!$permission)
        $permission=array();

       return in_array($attribute, $permission);
    
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) : bool

    {


          // ROLE_SUPER_ADMIN can do anything! The power!
          if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }
        
        //   return true;
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }
  
    if (in_array("ROLE_SUPER_ADMIN", $this->security->getUser()->getRoles())) {

        return true;
    }

        switch ($attribute) {
            case 'VIEW_USER':


                break;
            case 'POST_VIEW':

                break;
        }

        $permission = $this->session->get("PERMISSION");
        if (!$permission)
            $permission = array();

        return in_array($attribute, $permission) | in_array('rlspad',  $user->getRoles());
    }
}