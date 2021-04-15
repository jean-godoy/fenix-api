<?php

namespace App\Repository;

use App\Entity\FormPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormPayment[]    findAll()
 * @method FormPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormPayment::class);
    }

    // /**
    //  * @return FormPayment[] Returns an array of FormPayment objects
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
    public function findOneBySomeField($value): ?FormPayment
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
