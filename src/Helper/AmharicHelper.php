<?php
namespace App\Helper;
use DateTime;
use Andegna\DateTime as AD;
use App\Entity\PlanningQuarter;
use Doctrine\ORM\EntityManagerInterface;
use Andegna\DateTimeFactory;
use Andegna\DateTime as AndegnaDateTime;
use DateTimeZone;

class AmharicHelper 
{


    public static function getEthHour(){
      
        $dt=new AndegnaDateTime( new DateTime('now', new DateTimeZone('Africa/Addis_Ababa')));
        $dt->format('h:i:s');
        $hr=$dt->getHour();
        if($hr<=6)
        $hr+=6;
        else

        $hr-=6;
        return $hr;
    }

    public static function fromGretoEthstr($gregorian)
    {
        $ethipic = new AD($gregorian);
        return $ethipic->format('F j Y');
    }
    public static function fromGretoEthstrint($gregorian)
    {
        # code..
        $ethipic = new AD($gregorian);
        return $ethipic->format('F j');
    }
    /////////////////////////////////////////////////////
      public static function fromEthtoGre($ethipic)
    {
           $pref   = explode('/',$ethipic); 
           $ethidate = DateTimeFactory::of( $pref[2],  $pref[1],$pref[0]);

        return $ethidate->toGregorian();
    }
/////////////////////////////////////////
     public static function getCurrentYear()
    {
        $gregorian= new DateTime();
        $ethipic = new AD($gregorian);
        // dump($gregorian);
        return $ethipic->getYear();
    }


      public static function getCurrentYearPara($gregorian)
    {
        $ethipic = new AD($gregorian);
        // dump($gregorian);
        return $ethipic->format('Y');
    }
    
     public static function getCurrentDay(){
        $gregorian = new DateTime();
        $ethipic = new AD($gregorian);
        return $ethipic->getDay();
    }
     public static function getCurrentMonth()
    {
     

        $gregorian = new DateTime();
        $ethipic = new AD($gregorian);

        // dump($gregorian);
        return $ethipic->getMonth();
    }
    //get current Quarter
    public static function getCurrentQuarter( EntityManagerInterface $em )
    {
        $quarterId = 0;
        $time = new DateTime('now');
        $quarters = $em->getRepository(PlanningQuarter::class)->findAll();
        foreach ($quarters as $quarter) {
            if ($time >= $quarter->getStartDate() && $time < $quarter->getEndDate()) {
                $quarterId = $quarter->getId();
            }
        }
        return $quarterId;

    }
    
}
