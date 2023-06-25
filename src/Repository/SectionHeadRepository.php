<?php

namespace App\Repository;

use App\Entity\SectionHead;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SectionHead>
 *
 * @method SectionHead|null find($id, $lockMode = null, $lockVersion = null)
 * @method SectionHead|null findOneBy(array $criteria, array $orderBy = null)
 * @method SectionHead[]    findAll()
 * @method SectionHead[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionHeadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SectionHead::class);
    }

    public function save(SectionHead $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SectionHead $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getQuery($search=null)
    {
        $qb= $this->createQueryBuilder('a');
        $qb->andWhere("a.year  like '%$search%'");
        $qb->orderBy('a.id', 'DESC');
           return  $qb->getQuery();
    }


//    /**
//     * @return SectionHead[] Returns an array of SectionHead objects
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

//    public function findOneBySomeField($value): ?SectionHead
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
