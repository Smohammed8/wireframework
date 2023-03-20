<?php

namespace App\Repository;

use App\Entity\FieldOfStudy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FieldOfStudy>
 *
 * @method FieldOfStudy|null find($id, $lockMode = null, $lockVersion = null)
 * @method FieldOfStudy|null findOneBy(array $criteria, array $orderBy = null)
 * @method FieldOfStudy[]    findAll()
 * @method FieldOfStudy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FieldOfStudyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FieldOfStudy::class);
    }

    public function save(FieldOfStudy $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FieldOfStudy $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FieldOfStudy[] Returns an array of FieldOfStudy objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FieldOfStudy
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
