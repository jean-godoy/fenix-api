<?php

namespace App\Repository;

use App\Entity\TabelaPagamentos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TabelaPagamentos|null find($id, $lockMode = null, $lockVersion = null)
 * @method TabelaPagamentos|null findOneBy(array $criteria, array $orderBy = null)
 * @method TabelaPagamentos[]    findAll()
 * @method TabelaPagamentos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TabelaPagamentosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TabelaPagamentos::class);
    }

    // /**
    //  * @return TabelaPagamentos[] Returns an array of TabelaPagamentos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TabelaPagamentos
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
