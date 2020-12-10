<?php

namespace App\Repository;

use App\Entity\GradeRomaneio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GradeRomaneio|null find($id, $lockMode = null, $lockVersion = null)
 * @method GradeRomaneio|null findOneBy(array $criteria, array $orderBy = null)
 * @method GradeRomaneio[]    findAll()
 * @method GradeRomaneio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GradeRomaneioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GradeRomaneio::class);
    }

    // /**
    //  * @return GradeRomaneio[] Returns an array of GradeRomaneio objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GradeRomaneio
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
