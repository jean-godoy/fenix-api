<?php

namespace App\Repository;

use App\Entity\FaccaoSequenciaOperacional;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FaccaoSequenciaOperacional|null find($id, $lockMode = null, $lockVersion = null)
 * @method FaccaoSequenciaOperacional|null findOneBy(array $criteria, array $orderBy = null)
 * @method FaccaoSequenciaOperacional[]    findAll()
 * @method FaccaoSequenciaOperacional[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FaccaoSequenciaOperacionalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FaccaoSequenciaOperacional::class);
    }

    // /**
    //  * @return FaccaoSequenciaOperacional[] Returns an array of FaccaoSequenciaOperacional objects
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
    public function findOneBySomeField($value): ?FaccaoSequenciaOperacional
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
