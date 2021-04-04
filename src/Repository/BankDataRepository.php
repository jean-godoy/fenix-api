<?php

namespace App\Repository;

use App\Entity\BankData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BankData|null find($id, $lockMode = null, $lockVersion = null)
 * @method BankData|null findOneBy(array $criteria, array $orderBy = null)
 * @method BankData[]    findAll()
 * @method BankData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankData::class);
    }

    // /**
    //  * @return BankData[] Returns an array of BankData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BankData
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
