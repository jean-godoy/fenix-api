<?php

namespace App\Repository;

use App\Entity\RomaneioFooter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RomaneioFooter|null find($id, $lockMode = null, $lockVersion = null)
 * @method RomaneioFooter|null findOneBy(array $criteria, array $orderBy = null)
 * @method RomaneioFooter[]    findAll()
 * @method RomaneioFooter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RomaneioFooterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RomaneioFooter::class);
    }

    // /**
    //  * @return RomaneioFooter[] Returns an array of RomaneioFooter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RomaneioFooter
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
