<?php

namespace App\Repository;

use App\Entity\Checking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Checking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Checking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Checking[]    findAll()
 * @method Checking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Checking::class);
    }

    // /**
    //  * @return Checking[] Returns an array of Checking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Checking
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
