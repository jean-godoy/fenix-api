<?php

namespace App\Repository;

use App\Entity\FaccaoGrades;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FaccaoGrades|null find($id, $lockMode = null, $lockVersion = null)
 * @method FaccaoGrades|null findOneBy(array $criteria, array $orderBy = null)
 * @method FaccaoGrades[]    findAll()
 * @method FaccaoGrades[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FaccaoGradesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FaccaoGrades::class);
    }

    // /**
    //  * @return FaccaoGrades[] Returns an array of FaccaoGrades objects
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
    public function findOneBySomeField($value): ?FaccaoGrades
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
