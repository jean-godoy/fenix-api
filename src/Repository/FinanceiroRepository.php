<?php

namespace App\Repository;

use App\Entity\Financeiro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Financeiro|null find($id, $lockMode = null, $lockVersion = null)
 * @method Financeiro|null findOneBy(array $criteria, array $orderBy = null)
 * @method Financeiro[]    findAll()
 * @method Financeiro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinanceiroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Financeiro::class);
    }

    // /**
    //  * @return Financeiro[] Returns an array of Financeiro objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Financeiro
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
