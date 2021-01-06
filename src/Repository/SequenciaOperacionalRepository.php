<?php

namespace App\Repository;

use App\Entity\SequenciaOperacional;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SequenciaOperacional|null find($id, $lockMode = null, $lockVersion = null)
 * @method SequenciaOperacional|null findOneBy(array $criteria, array $orderBy = null)
 * @method SequenciaOperacional[]    findAll()
 * @method SequenciaOperacional[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SequenciaOperacionalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SequenciaOperacional::class);
    }

    // /**
    //  * @return SequenciaOperacional[] Returns an array of SequenciaOperacional objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SequenciaOperacional
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
