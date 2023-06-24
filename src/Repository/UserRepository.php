<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }


    public function getQuery($search=null)
    {
        $qb= $this->createQueryBuilder('a');
        $qb->andWhere("a.username  like '%$search%'");
        $qb->orderBy('a.id', 'DESC');
           return  $qb->getQuery();
    }


    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }



    public function total_users()
    {
        $qb = $this->createQueryBuilder('a')
            ->select('count(a.id) as user')
            ->getQuery()
            ->getSingleScalarResult();
          
            return $qb;
            
    }

    public function getParents()
    {
        $oprator =   'PARENT';
        $qb= $this->createQueryBuilder('a');
        $qb->andWhere('a.roles LIKE :roles') ->setParameter('roles', '%"'.$oprator.'"%');

        $qb->orderBy('a.id', 'DESC');
           return  $qb->getQuery()->getResult();
            
    }
    public function getTeachers()
    {
        $oprator =   'TEACHER';
        $qb= $this->createQueryBuilder('a');
        $qb->andWhere('a.roles LIKE :roles') ->setParameter('roles', '%"'.$oprator.'"%');

        $qb->orderBy('a.id', 'DESC');
           return  $qb->getQuery()->getResult();
            
    }

    public function getCommittee()
    {
        $oprator =   'COMMITTEE';
        $qb= $this->createQueryBuilder('a');
        $qb->andWhere('a.roles LIKE :roles') ->setParameter('roles', '%"'.$oprator.'"%');

        $qb->orderBy('a.id', 'DESC');
           return  $qb->getQuery()->getResult();
            
    }
    public function findForUserGroup($usergroup = null)
    {
        $qb = $this->createQueryBuilder('u');

        if (sizeof($usergroup)) {

            $qb->andWhere('u.id not in ( :usergroup )')
                ->setParameter('usergroup', $usergroup);
        }
        
        return $qb->orderBy('u.id', 'ASC')
            ->getQuery()->getResult();
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
