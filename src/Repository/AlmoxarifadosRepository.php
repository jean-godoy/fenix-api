<?php

namespace App\Repository;

use App\Entity\Almoxarifados;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Almoxarifados|null find($id, $lockMode = null, $lockVersion = null)
 * @method Almoxarifados|null findOneBy(array $criteria, array $orderBy = null)
 * @method Almoxarifados[]    findAll()
 * @method Almoxarifados[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlmoxarifadosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Almoxarifados::class);
    }

    // /**
    //  * @return Almoxarifados[] Returns an array of Almoxarifados objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Almoxarifados
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
