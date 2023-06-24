<?php

namespace App\Repository;

use App\Entity\StudentUpload;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudentUpload>
 *
 * @method StudentUpload|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentUpload|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentUpload[]    findAll()
 * @method StudentUpload[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentUploadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentUpload::class);
    }

    public function save(StudentUpload $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getQuery($search=null)
    {
        $qb= $this->createQueryBuilder('a');
        $qb->orderBy('a.upload', 'DESC');
           return  $qb->getQuery();
    }

    public function remove(StudentUpload $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return StudentUpload[] Returns an array of StudentUpload objects
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

//    public function findOneBySomeField($value): ?StudentUpload
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
