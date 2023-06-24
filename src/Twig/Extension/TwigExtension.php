<?php
namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use App\Entity\Level;
use App\Repository\SalaryScaleRepository;
use Twig\TwigFunction;
use Symfony\Component\Form\FormView;
use DateTime;
use Andegna\DateTime as eth_date;
use \Twig_Extension;    
use Andegna\Constants;
use Andegna\DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Helper\Utils;
use App\Helper\PayrollHelper;

use Andegna\Validator\DateValidator;

use function PHPUnit\Framework\returnSelf;

class TwigExtension extends AbstractExtension{

 

    private $salaryScaleRepository;
    private $entityManager;
    private $urlGeneratorInterface;
    private $templating;
    private $level;
    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $urlGeneratorInterface, \Twig\Environment $templating)
    {

        $this->entityManager = $em;
        $this->urlGeneratorInterface = $urlGeneratorInterface;
        $this->templating = $templating;
    }


 public function getFilters(): array
    {
        return [
       
            new TwigFilter('eth_date', [$this, 'toEthiopianDate']),
            new TwigFilter('age', [$this, 'age']),
            new TwigFilter('salary', [$this, 'getSalary']),
            new TwigFilter('getMonth', [$this, 'getMonthName']),
           
            new TwigFilter('eth_date2', [$this, 'toEthiopianDate2']),
            new TwigFilter('net', [$this, 'getNet']),
            new TwigFilter('duduct', [$this, 'getDeducted']),
            new TwigFilter('tax', [$this, 'getTax']),
            new TwigFilter('pension', [$this, 'getPension']),
          

          
        ];
    }
    public function getFunctions(): array
    {
        return [
            // new TwigFunction('salary', [$this, 'getSalary']),
            //new TwigFunction('net', [$this, 'getNetIncome']),
            new TwigFunction('eth_date', [$this, 'toEthiopianDate']),
            new TwigFunction('eth_date3', [$this, 'toEthiopianDate3']),
            new TwigFunction('age', [$this, 'age']),
            new TwigFunction('age2', [$this, 'age2']),
            new TwigFunction('dateSub', [$this, 'dateSub']),
            new TwigFunction('ago', [$this, 'ago']),
            
        ];
    }

    public function toEthiopianDate(DateTime $value=null)
    {
        if($value==null){
            $value=new DateTime('now');
        }
        return (new eth_date($value))->format("l, M  d/Y");
    }
  




    public function toEthiopianDate2(DateTime $value=null)
    {
        if($value=null){
            $value=new DateTime('now');
        }
      //  return (new eth_date($value))->format("l, M  d/Y h:i A");
        return (new eth_date($value))->format("d/m/Y");
    }
   

    public function getSalary($level)
    {

    return  $this->salaryScaleRepository->find($level)->getStartSalary();
      
    }

    // public function getNet($amoint)
    // {
    //     return PayrollHelper::getNetIncome($amoint);
    // }

    // public function getDeducted($amoint)
    // {
    //     return PayrollHelper::getDeducation($amoint);
    // }
    // public function getTax($amoint)
    // {
    //     return PayrollHelper::getTax($amoint);
    // }

    // public function getPension($amoint)
    // {
    //     return PayrollHelper::getPension($amoint);
    // }

    /*
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
            new TwigFilter('cast_to_array', [$this, 'objectFilter']),

        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('age', [$this, 'age']),
            new TwigFunction('age2', [$this, 'age2']),
            new TwigFunction('dateSub', [$this, 'dateSub']),
            new TwigFunction('ago', [$this, 'ago']),

            //new TwigFunction('mul', [$this, 'calculateArea']),
        ];
    }
    */
public function getMonthName($name){

                if($name == 1 )
                return 'Sep';
                else if($name == 2)
                return 'Oct';
                else if($name == 3)
                return 'Nov';
                else if($name == 4)
                return 'Dec';
                else if($name == 5)
                return 'Jan';
                else if($name == 6)
                return 'Feb';
                else if($name == 7)
                return 'Mar';
                else if($name == 8)
                return 'Apr';
                else if($name == 9)
                return 'May';
                else if($name == 10)
                return 'Jun';
                else if($name == 11)
                return  'July';
                else if($name == 12)
                return 'Aug';
                else
                return 'Puagme';
    }

    public function fromGretoEth($gregorian)
    {

        return Utils::fromGretoEth($gregorian);
    }
    public function fromGretoEthstr($gregorian)
    {
        # code..
        $ethipic = new eth_date($gregorian);
      //  dump($gregorian);
        return $ethipic->format('F j Y');
    }
    public function fromGretoEthstrint($gregorian)
    {
        # code..
        $ethipic = new eth_date($gregorian);
        return $ethipic->format('F j');
    }
    public function nowEth()
    {
        
        return Utils::nowEth();
    }
    public function fromGretoEthstrM($gregorian)
    {
        # code..
        $ethipic = new eth_date($gregorian);
        return $ethipic->format('F');
    }
    public function fromEthtoGre($ethipic)
    {
        # code..
        return $ethipic->toGregorian();
    }


    public function getNextSchedule($date, $plus)
    {
        $next = clone $date;
        $next = $next->modify("+ $plus day");
        $ethipic = new eth_date($next);
        return $ethipic->format('F j Y D');
        // return $next->format("Y-m-d");
    }
    public function missed($date)
    {
        $now = new DateTime;
        if ($date < $now)
            return true;
        else
            return false;
    }


    public function dateSub($from,$to)
    {
        $start_t = $from;
        $current_t = $to;
        $difference = $start_t ->diff($current_t );
        $return_time = $difference ->format('%H:%I:%S');
        return $return_time;
    }
    public function ago($datetime, $full = false)
    {
        $datetime = $datetime->format('Y-m-d H:i:s');
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }


    public function canTake($date, $plus)
    {
        $next = clone $date;
        $next = $next->modify("+ $plus day");
        $now = new DateTime;

        // return $next->format("Y-m-d");
        $diff = $now->diff($next);

        return  $now;
    }



    function age($birthdate, $type = 0)
    {

        if ($birthdate == null) return "Undefined";
        return Utils::age($birthdate, $type);
    }
    function radiologyMenu()
    {

        $allmachine = $this->entityManager->getRepository(RadiologyMachineType::class)->find(3);

        $res = $this->templating->render("menus/radrequestmenu.html.twig", ["radiology_requests" => $allmachine]);
        return $res;
    }
    function age2($birthdate, $type = 0)
    {
        // return($birthdate);
        if ($birthdate == null) return "Undefined";
        return Utils::age2($birthdate, $type);
    }
    function countIssued()
    {
        
         $total_days=General::getIssuedCount($this->entityManager);
         return($total_days);
            // if ($birthdate == null) return "Undefined";
        // return Utils::age2($birthdate, $type);
    }

    /*public function objectFilter($stdClassObject) {
        // Just typecast it to an array
        $arr=array();
        $response = (array)$stdClassObject;
        foreach($response as $key => $value) 
        {
            $arr[ $key]=$value;
        }
        return $arr;
    }*/
}

    
