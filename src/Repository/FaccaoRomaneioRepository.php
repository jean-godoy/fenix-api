<?php

namespace App\Repository;

use App\Entity\FaccaoRomaneio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FaccaoRomaneio|null find($id, $lockMode = null, $lockVersion = null)
 * @method FaccaoRomaneio|null findOneBy(array $criteria, array $orderBy = null)
 * @method FaccaoRomaneio[]    findAll()
 * @method FaccaoRomaneio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FaccaoRomaneioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FaccaoRomaneio::class);
    }

    // /**
    //  * @return FaccaoRomaneio[] Returns an array of FaccaoRomaneio objects
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
    public function findOneBySomeField($value): ?FaccaoRomaneio
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
