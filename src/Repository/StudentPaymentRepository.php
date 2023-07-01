<?php

namespace App\Repository;

use App\Entity\StudentPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudentPayment>
 *
 * @method StudentPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentPayment[]    findAll()
 * @method StudentPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentPayment::class);
    }

    public function save(StudentPayment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StudentPayment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getQuery($student)
    {
        $qb= $this->createQueryBuilder('a');
        $qb->andWhere('a.student = :val')->setParameter('val', $student);
        $qb->orderBy('a.id', 'DESC');
           return  $qb->getQuery()->getResult();
    }

    
//    /**
//     * @return StudentPayment[] Returns an array of StudentPayment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StudentPayment
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
